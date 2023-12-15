<?php

declare(strict_types=1);

namespace Common\Application\Bus\Command;

/**
 * The CommandBus interface defines a contract for a command bus.
 * A command bus is responsible for dispatching commands to their appropriate handlers.
 * It has a single method, dispatch, which takes a Command as an argument and returns void.
 * The dispatch method is responsible for finding the appropriate handler for the command and invoking it.
 */
interface CommandBus
{
    /**
     * Dispatches the given command to its appropriate handler.
     * The method does not return a value.
     *
     * @param Command $command the command to be dispatched
     */
    public function dispatch(Command $command): void;
}
