<?php

declare(strict_types=1);

namespace Common\Domain\ValueObject;

use Common\Domain\Exception\ValidationException;
use Common\Domain\Validation\ConstraintType;
use Common\Domain\Validation\Formatter\ValidationErrorFormatter;

/**
 * Abstract class Uuid.
 *
 * Provides functionalities for generating and validating UUIDs.
 * This class uses Symfony's Uuid component (LEAK), which is an exception to the
 * general rule of not importing external components directly in the domain layer.
 * This specific implementation is chosen for its reliability and simplicity,
 * but if a change is needed in the future, it will only affect this class.
 */
abstract class Uuid implements \Stringable
{
    /**
     * StringValueObject constructor.
     *
     * @param string $value the string value to be wrapped by the object
     *
     * @throws ValidationException
     */
    public function __construct(
        protected string $value
    ) {
        if (!self::validateUuid($value)) {
            throw new ValidationException([ValidationErrorFormatter::format(ConstraintType::INVALID, 'id', $value)]);
        }
    }

    /**
     * Generate a new UUID.
     *
     * @return string the generated UUID in RFC 4122 format
     */
    public static function generateUuid(): string
    {
        return \Symfony\Component\Uid\Uuid::v4()->toRfc4122();
    }

    /**
     * Validate a given UUID.
     *
     * @return bool true if the UUID is valid, false otherwise
     */
    public static function validateUuid(string $uuid): bool
    {
        return \Symfony\Component\Uid\Uuid::isValid($uuid);
    }

    /**
     * Get the string value.
     *
     * @return string the string value wrapped by the object
     */
    final public function value(): string
    {
        return $this->value;
    }

    /**
     * Convert the object to a string.
     *
     * This method allows objects of this class to be used in contexts that expect a string.
     * It returns the string value wrapped by the object.
     *
     * @return string the string value wrapped by the object
     */
    final public function __toString(): string
    {
        return $this->value();
    }
}
