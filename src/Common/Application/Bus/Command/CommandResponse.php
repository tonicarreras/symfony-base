<?php

declare(strict_types=1);

namespace Common\Application\Bus\Command;

/**
 * The CommandResponse interface is a marker interface, which means it does not define any methods.
 * It is used to mark classes that should be treated as responses to commands.
 * Command responses are DTOs (Data Transfer Objects) that carry the result of a command execution.
 * Each command handler should return a CommandResponse.
 */
interface CommandResponse {}