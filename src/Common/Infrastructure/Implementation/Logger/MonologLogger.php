<?php

namespace Common\Infrastructure\Implementation\Logger;

use Common\Domain\Service\Logger\Logger;

/**
 * Class MonologLogger
 * This class implements the Logger interface using the Monolog library.
 * It provides methods to log informational, warning, and critical messages.
 */
final readonly class MonologLogger implements Logger
{
    /**
     * MonologLogger constructor.
     *
     * @param \Monolog\Logger $logger the Monolog logger instance
     */
    public function __construct(private \Monolog\Logger $logger)
    {
    }

    /**
     * Logs an informational message using the Monolog logger.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * Logs a warning message using the Monolog logger.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    /**
     * Logs a critical message using the Monolog logger.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}
