<?php

declare(strict_types=1);

namespace Common\Domain\Utils\Trait;

/**
 * Trait providing string manipulation utilities.
 *
 * This trait includes methods for common string operations that can be used in various parts of the domain.
 * It encapsulates logic for string transformations, ensuring consistency and usability.
 */
trait StringUtil
{
    /**
     * Converts a given string to snake_case.
     *
     * This method transforms a camelCase or PascalCase string into a snake_case string.
     * It's particularly useful for formatting identifiers or keys where snake_case is the convention,
     * such as database fields, JSON keys, etc.
     *
     * @param string $text the string to convert to snake_case
     *
     * @return string the snake_case formatted string
     */
    public static function toSnakeCase(string $text): string
    {
        if (ctype_lower($text)) {
            return $text;
        }
        return strtolower(preg_replace('/([^A-Z\s])([A-Z])/', '$1_$2', $text));
    }
}
