<?php

declare(strict_types=1);

namespace Common\Domain\ValueObject;

/**
 * Abstract class Uuid.
 *
 * Provides functionalities for generating and validating UUIDs.
 * This class uses Symfony's Uuid component (LEAK), which is an exception to the
 * general rule of not importing external components directly in the domain layer.
 * This specific implementation is chosen for its reliability and simplicity,
 * but if a change is needed in the future, it will only affect this class.
 */
abstract class Uuid
{
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
}
