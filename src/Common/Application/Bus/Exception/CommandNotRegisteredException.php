<?php

namespace Common\Application\Bus\Exception;

use Common\Application\Bus\Command\Command;

final class CommandNotRegisteredException extends \RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = $command::class;

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}
