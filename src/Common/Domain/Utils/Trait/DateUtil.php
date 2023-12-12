<?php

declare(strict_types=1);

namespace Common\Domain\Utils\Trait;

use DateTimeInterface;

/**
 * Trait providing utility methods for date manipulation.
 *
 * This trait can be used in any class that requires common date-related functionalities,
 * ensuring consistency in handling date and time values across the domain.
 */
trait DateUtil
{
    /**
     * Converts a DateTimeInterface object to a standardized string format.
     *
     * This method takes a DateTimeInterface instance and converts it into a string using the
     * standardized ATOM format (e.g., "2021-03-10T02:50:00+00:00"). This format is particularly useful for
     * ensuring consistent date-time representations in APIs, databases, and other external interfaces.
     *
     * @param \DateTimeInterface $date the date to convert
     *
     * @return string the date as a formatted string
     */
    public static function dateToString(\DateTimeInterface $date): string
    {
        return $date->format(\DateTimeInterface::ATOM);
    }

    /**
     * @throws \Exception
     */
    public static function stringToDate(string $date): \DateTimeImmutable
    {
        return new \DateTimeImmutable($date);
    }
}
