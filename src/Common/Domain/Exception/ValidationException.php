<?php

declare(strict_types=1);

namespace Common\Domain\Exception;

use Common\Domain\Exception\Constant\ExceptionMessage;
use Common\Domain\Exception\Constant\ExceptionType;

/**
 * ValidationException class for handling validation errors.
 *
 * This exception is used to encapsulate details about validation errors that occur
 * during the processing of a request. It extends the ApiException class, providing
 * specific information about the nature of the validation error through an array
 * of violations.
 */
class ValidationException extends ApiException
{
    /**
     * @var array an array containing details about the validation violations
     */
    private array $violations;

    /**
     * Constructor for the ValidationException class.
     *
     * @param array $violations an array detailing the validation errors encountered
     */
    public function __construct(array $violations)
    {
        parent::__construct(422, ExceptionMessage::VALIDATION, ExceptionType::VALIDATION);
        $this->violations = $violations;
    }

    /**
     * Retrieves the validation violations.
     *
     * @return array an array of validation violations
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
