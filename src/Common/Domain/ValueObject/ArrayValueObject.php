<?php

namespace Common\Domain\ValueObject;

/**
 * Abstract class ArrayValueObject.
 *
 * This class provides a way to represent array values as objects.
 */
abstract class ArrayValueObject implements \Stringable, \Countable
{
    /**
     * ArrayValueObject constructor.
     *
     * @param array $value the array value to be wrapped by the object
     */
    public function __construct(
        protected array $value
    ) {
    }

    /**
     * Get the array value.
     *
     * @return array|string[] the array value wrapped by the object
     */
    final public function value(): array
    {
        return $this->value;
    }

    /**
     * Get the JSON representation of the object.
     *
     * @return string the JSON representation of the object
     *
     * @throws \JsonException
     */
    final public function toJson(): string
    {
        return json_encode($this->value, JSON_THROW_ON_ERROR);
    }

    /**
     * Convert the object to a string.
     *
     * This method allows objects of this class to be used in contexts that expect a string.
     * It returns the JSON representation of the object.
     *
     * @return string the JSON representation of the object
     *
     * @throws \JsonException
     */
    final public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * Count elements of an object.
     *
     * @return int the custom count as an integer
     */
    public function count(): int
    {
        return count($this->value);
    }
}
