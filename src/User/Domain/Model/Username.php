<?php

namespace User\Domain\Model;

use Common\Application\Exception\ValidationException;
use Common\Application\Validation\Trait\LengthValidationTrait;
use Common\Application\Validation\Trait\NotBlankValidationTrait;
use Common\Domain\ValueObject\StringValueObject;

/**
 * Class Username.
 *
 * This class represents a username in the domain model. It extends the StringValueObject class and uses
 * the NotBlankValidationTrait and LengthValidationTrait for validation. The username must be between 4 and 20 characters.
 */
final readonly class Username extends StringValueObject
{
    use NotBlankValidationTrait;
    use LengthValidationTrait;

    public const int MIN_LENGTH = 4;
    public const int MAX_LENGTH = 20;
    private const string FIELD_NAME = 'username';

    /**
     * Username constructor.
     * Validates that the username is not blank and that its length is between the minimum and maximum allowed lengths.
     *
     * @param string $value The username value
     *
     * @throws ValidationException
     */
    public function __construct(string $value)
    {
        $violations = array_merge(
            $this->validateNotBlank($value, self::FIELD_NAME),
            $this->validateLength($value, self::MIN_LENGTH, self::MAX_LENGTH, self::FIELD_NAME)
        );
        if (!empty($violations)) {
            throw new ValidationException($violations);
        }
        parent::__construct($value);
    }
}
