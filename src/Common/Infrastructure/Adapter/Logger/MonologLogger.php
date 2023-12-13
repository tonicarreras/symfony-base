<?php

namespace Common\Infrastructure\Adapter\Logger;

use Common\Domain\Logger\Logger;

/**
 * Class MonologLogger
 * This class implements the Logger interface using the Monolog library.
 * It provides methods to log informational, warning, and critical messages.
 */
final readonly class MonologLogger implements Logger
{
    /**
     * MonologLogger constructor.
     * @param \Monolog\Logger $logger The Monolog logger instance.
     */
    public function __construct(private \Monolog\Logger $logger) {}

    /**
     * Logs an informational message using the Monolog logger.
     *
     * @param string $message The message to be logged.
     * @param array $context The context in which the message is being logged.
     * @return void
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * Logs a warning message using the Monolog logger.
     *
     * @param string $message The message to be logged.
     * @param array $context The context in which the message is being logged.
     * @return void
     */
    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    /**
     * Logs a critical message using the Monolog logger.
     *
     * @param string $message The message to be logged.
     * @param array $context The context in which the message is being logged.
     * @return void
     */
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}