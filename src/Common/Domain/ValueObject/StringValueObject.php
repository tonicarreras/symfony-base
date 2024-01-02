<?php

namespace Common\Domain\ValueObject;

/**
 * Abstract class StringValueObject.
 *
 * This class provides a way to represent string values as objects.
 * It implements the Stringable interface, which means objects of this class can be used in contexts that expect a string.
 */
abstract readonly class StringValueObject implements \Stringable
{
    /**
     * StringValueObject constructor.
     *
     * @param string $value the string value to be wrapped by the object
     */
    public function __construct(
        protected string $value
    ) {
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
