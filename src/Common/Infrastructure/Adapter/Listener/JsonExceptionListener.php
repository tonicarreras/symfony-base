<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Listener;

use Common\Application\Exception\ValidationException;
use Common\Application\Validation\ConstraintKey;
use Common\Application\Validation\Formatter\ValidationErrorFormatter;
use Common\Domain\Exception\ApiException;
use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionStatusCode;
use Common\Domain\Exception\Constant\ExceptionType;
use Common\Domain\Service\Logger\Logger;
use Common\Infrastructure\Adapter\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

/**
 * Class JsonExceptionListener.
 *
 * This class listens for exceptions thrown by the application and formats them into a JSON response.
 * It also logs exceptions if the response status code is an internal error.
 */
final readonly class JsonExceptionListener
{
    /**
     * Array of exceptions that are allowed to be thrown by the application.
     */
    public const array CUSTOM_EXCEPTIONS_FOR_USER = [
        HttpExceptionInterface::class, // \Symfony
        ApiException::class, // \Exception
        // (...)
    ];

    /**
     * JsonExceptionListener constructor.
     *
     * @param Logger $logger the logger instance
     */
    public function __construct(
        private Logger $logger
    ) {
    }

    /**
     * This method is called when an exception occurs in the kernel.
     *
     * @param ExceptionEvent $event the event object containing the exception and request details
     *
     * @throws ApiException
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = $this->createJsonResponse($exception);
        $this->logException($response, $exception);
        $event->setResponse($response);
    }

    /**
     * Creates a JSON response based on the exception and the request.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return JsonResponse the JSON response to be returned
     *
     * @throws ApiException
     */
    private function createJsonResponse(\Throwable $exception): JsonResponse
    {
        $statusCode = $this->getStatusCode($exception);

        return ErrorResponse::response(
            $this->getErrorData($exception),
            $statusCode,
            $this->getErrorMessage($exception, $statusCode),
            $this->getErrorType($exception)
        );
    }

    /**
     * Generates an appropriate error message or throws a ValidationException.
     *
     * @param \Throwable $exception  the caught exception
     * @param int        $statusCode the HTTP status code
     *
     * @return string the error message
     */
    private function getErrorMessage(\Throwable $exception, int $statusCode): string
    {
        if (ExceptionStatusCode::INTERNAL_ERROR === $statusCode) {
            return ExceptionMessage::INTERNAL;
        }
        if ($exception instanceof HttpExceptionInterface && $exception->getPrevious() instanceof ValidationFailedException) {
            return ExceptionMessage::VALIDATION;
        }

        return $exception->getMessage();
    }

    /**
     * Determines the type of error based on the exception.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return string the error type
     */
    private function getErrorType(\Throwable $exception): string
    {
        if ($exception instanceof ApiException) {
            return $exception->getType();
        }

        return ExceptionType::EXCEPTION;
    }

    /**
     * Retrieves error data from the exception if applicable.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return array|null error data or null
     *
     * @throws ApiException
     */
    private function getErrorData(\Throwable $exception): ?array
    {
        if ($exception instanceof ValidationException) {
            return $exception->getViolations();
        }

        if ($exception instanceof HttpExceptionInterface && $exception->getPrevious() instanceof ValidationFailedException) {
            /* @var ValidationFailedException $validationException */
            $validationException = $exception->getPrevious();

            return $this->formatSymfonyConstraintsViolations($validationException->getViolations());
        }

        return null;
    }

    /**
     * Format validation exception errors.
     *
     * @param ConstraintViolationListInterface $violations the list of constraint violations
     *
     * @return array the formatted violations
     *
     * @throws ApiException
     */
    private function formatSymfonyConstraintsViolations(ConstraintViolationListInterface $violations): array
    {
        $formattedViolations = [];

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $propertyPath = $violation->getPropertyPath();
            if ('' === $propertyPath) {
                throw new ApiException(ExceptionMessage::INVALID_PAYLOAD, ExceptionStatusCode::BAD_REQUEST);
            }

            $constraint = $violation->getConstraint();
            $constraintKey = self::symfonyConstraintKeyMap($constraint);
            $formattedViolations[] = ValidationErrorFormatter::format(
                $constraintKey,
                $propertyPath,
                $violation->getInvalidValue()
            );
        }

        return $formattedViolations;
    }

    /**
     * Maps Symfony constraint violation keys to application-specific keys.
     *
     * @return string|null the application-specific key for the constraint
     */
    private static function symfonyConstraintKeyMap(?Constraint $constraint): ?string
    {
        return match (true) {
            $constraint instanceof NotBlank => ConstraintKey::NOT_BLANK,
            $constraint instanceof NotNull => ConstraintKey::NOT_NULL,
            $constraint instanceof Length => self::getLengthConstraintKey($constraint),
            $constraint instanceof Choice => ConstraintKey::INVALID,
            default => '',
        };
    }

    /**
     * Gets the length constraint key.
     *
     * @return string|void
     */
    private static function getLengthConstraintKey(Length $constraint)
    {
        if (null !== $constraint->min && $constraint->min > 0) {
            return ConstraintKey::MIN_LENGTH;
        }
        if (null !== $constraint->max && $constraint->max > 0) {
            return ConstraintKey::MAX_LENGTH;
        }
    }

    /**
     * Determines the status code to be used in the response.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return int the status code
     */
    private function getStatusCode(\Throwable $exception): int
    {
        if ($this->isAllowedException($exception)) {
            // For Symfony HttpExceptionInterface, use getStatusCode() if it's enabled.
            if ($exception instanceof HttpExceptionInterface) {
                return $exception->getStatusCode();
            }

            // For allowed exceptions, use getCode() if it's enabled.
            return (int) $exception->getCode();
        }

        return ExceptionStatusCode::INTERNAL_ERROR;
    }

    /**
     * Determines if the given exception is allowed or not based on custom exceptions defined for users.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return bool true if the exception is allowed, false otherwise
     */
    private function isAllowedException(\Throwable $exception): bool
    {
        foreach (self::CUSTOM_EXCEPTIONS_FOR_USER as $allowedException) {
            if ($exception instanceof $allowedException) {
                return true;
            }
        }

        return false;
    }

    /**
     * Logs the exception if the response status code is an internal error.
     *
     * @param JsonResponse $response  the response object
     * @param \Throwable   $exception the caught exception
     */
    private function logException(JsonResponse $response, \Throwable $exception): void
    {
        if (ExceptionStatusCode::INTERNAL_ERROR === $response->getStatusCode()) {
            $this->logger->critical(
                $exception->getMessage(), ['exception' => $exception->getTrace()]
            );
        }
    }
}
