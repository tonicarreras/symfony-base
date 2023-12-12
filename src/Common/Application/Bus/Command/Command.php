<?php

declare(strict_types=1);

namespace Common\Application\Bus\Command;

/**
 * The Command interface is a marker interface, which means it does not define any methods.
 * It is used to mark classes that should be treated as commands.
 * Commands are DTOs (Data Transfer Objects) that carry the intent of the user to change something in the system.
 * Each command should be handled by exactly one command handler.
 */
interface Command {}