<?php

declare(strict_types=1);

namespace Common\Infrastructure\Adapter\Listener;

use Common\Domain\Exception\ApiException;
use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;
use Common\Domain\Exception\ValidationException;
use Common\Domain\Logger\Logger;
use Common\Infrastructure\Adapter\Response\ErrorResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;


class JsonExceptionListener
{

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
        $event->setResponse($response);
        $this->logger->critical($exception->getMessage(), ['exception' => $exception->getTrace()]);
    }

    /**
     * Creates a JSON response based on the exception and the request.
     *
     * @param \Throwable $exception the caught exception
     *
     * @return ErrorResponse the JSON response to be returned
     */
    private function createJsonResponse(\Throwable $exception): ErrorResponse
    {
        $statusCode = $exception instanceof ApiException ? $exception->getCode() : 500;
        $message = $this->getErrorMessage($exception, $statusCode);

        return new ErrorResponse(
            $this->getErrorData($exception),
            $statusCode,
            $message,
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
        if (500 === $statusCode) {
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
        if ($exception instanceof ApiException) return $exception->getType();
        return ExceptionType::EXCEPTION;
    }
}
