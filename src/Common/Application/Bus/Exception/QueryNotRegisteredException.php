<?php

namespace Common\Application\Bus\Exception;

use Common\Domain\Exception\ApiException;

/**
 * The QueryNotRegisteredException class extends the ApiException class.
 * It represents a specific type of API exception that is thrown when a query is not registered in the system.
 * It has a status code of 409, which represents a conflict error in HTTP.
 * The error message is set to ExceptionMessage::DUPLICATE.
 */
final class QueryNotRegisteredException extends ApiException
{
    public const int STATUS_CODE = 409;
    public const string QUERY_NOT_REGISTERED = 'query_handler_not_registered';

    /**
     * The constructor initializes the QueryNotRegisteredException with a status code and an error message.
     * The status code is set to self::STATUS_CODE, and the error message is set to ExceptionMessage::DUPLICATE.
     */
    public function __construct()
    {
        parent::__construct(self::QUERY_NOT_REGISTERED, self::STATUS_CODE);
    }
}
