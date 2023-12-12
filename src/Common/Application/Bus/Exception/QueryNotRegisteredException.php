<?php

namespace Common\Application\Bus\Exception;

use Common\Application\Bus\Query\Query;

final class QueryNotRegisteredException extends \RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = $query::class;

        parent::__construct("The query <$queryClass> has no associated query handler");
    }
}
