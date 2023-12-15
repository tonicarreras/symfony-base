<?php

declare(strict_types=1);

namespace Common\Application\Bus\Command;

/**
 * The CommandHandler interface defines a contract for a command handler.
 * A command handler is responsible for handling commands dispatched by the command bus.
 * It does not define any methods, and serves as a marker interface.
 * Each command should have exactly one corresponding command handler.
 */
interface CommandHandler
{
}
