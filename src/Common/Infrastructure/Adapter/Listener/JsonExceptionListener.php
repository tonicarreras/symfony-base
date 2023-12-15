<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Listener;

use Common\Domain\Exception\ApiException;
use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Logger\Logger;
use Common\Infrastructure\Adapter\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


final readonly class JsonExceptionListener
{
    const int INTERNAL_ERROR_CODE = 500;

    public function __construct(
        private Logger $logger
    )
    {
    }

    /**
     * This method is called when an exception occurs in the kernel.
     *
     * @param ExceptionEvent $event the event object containing the exception and request details
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
     * Retrieves error data from the exception if applicable.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return mixed error data or null
     */
    private function getErrorData(\Throwable $exception): mixed
    {
        return $exception instanceof ValidationException ? $exception->getViolations() : null;
    }

    private function getStatusCode(\Throwable $exception): int
    {
        return match (true) {
            // For Symfony HttpExceptionInterface, get the status code from the exception.
            $exception instanceof HttpExceptionInterface =>
            $exception->getStatusCode(),
            $exception instanceof ApiException =>
            $exception->getCode(),
            default => self::INTERNAL_ERROR_CODE
        };
    }

    /**
     * Generates an appropriate error message or throws a ValidationException.
     *
     * @param \Throwable $exception the caught exception
     * @param int $statusCode the HTTP status code
     *
     * @return string the error message
     */
    private function getErrorMessage(\Throwable $exception, int $statusCode): string
    {
        if (self::INTERNAL_ERROR_CODE === $statusCode) {
            return ExceptionMessage::INTERNAL;
        }
        return $exception->getMessage();
    }

    /**
     * Determines the type of error based on the exception.
     *
     * @param \Throwable $exception the caught exception
     * @return string
     */
    private function getErrorType(\Throwable $exception): string
    {
        if ($exception instanceof ApiException) {
            return $exception->getType();
        }
        return ExceptionType::EXCEPTION;
    }

    /**
     * Logs the exception if the response status code is an internal error.
     *
     * @param JsonResponse $response the response object
     * @param \Throwable $exception the caught exception
     * @return void
     */
    private function logException(JsonResponse $response, \Throwable $exception): void
    {
        if (self::INTERNAL_ERROR_CODE === $response->getStatusCode()) {
            $this->logger->critical($exception->getMessage(), ['exception' => $exception->getTrace()]);
        }
    }
}
