<?php

namespace Common\Domain\Logger;

/**
 * Interface Logger
 * This interface defines the contract for a logger.
 * It provides methods for logging information, warnings, and critical messages.
 */
interface Logger
{
    /**
     * Logs an informational message.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function info(string $message, array $context = []): void;

    /**
     * Logs a warning message.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function warning(string $message, array $context = []): void;

    /**
     * Logs a critical message.
     *
     * @param string $message the message to be logged
     * @param array  $context the context in which the message is being logged
     */
    public function critical(string $message, array $context = []): void;
}
