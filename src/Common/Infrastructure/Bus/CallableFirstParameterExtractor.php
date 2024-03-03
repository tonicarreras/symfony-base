<?php

declare(strict_types=1);

namespace Common\Infrastructure\Bus;

use function Lambdish\Phunctional\map;
use function Lambdish\Phunctional\reindex;

/**
 * This class is responsible for determining the type of the first parameter of callable objects.
 * It is particularly useful for matching event handlers or similar callable objects with their
 * intended processing logic based on the parameter type they expect. This functionality can be
 * instrumental in event-driven architectures or systems where dynamic callback invocation is needed
 * based on specific types of events or requests.
 */
final class CallableFirstParameterExtractor
{
    /**
     * Processes an iterable of callables and determines the type of the first parameter for each.
     * This method uses a combination of mapping and reindexing functions to transform the given
     * callables into an array where each element represents the determined type.
     *
     * @param iterable $callables an iterable collection of callable objects to be processed
     *
     * @return array an array containing the types of the first parameters of the given callables
     */
    public static function forCallables(iterable $callables): array
    {
        return map(self::unflatten(), reindex(self::classExtractor(new self()), $callables));
    }

    /**
     * Returns a callable that extracts the class type of the first parameter of a given handler.
     *
     * @param self $parameterExtractor an instance of CallableFirstParameterExtractor
     *
     * @return callable a function that takes a handler object and returns the class name of its first parameter, or null if not applicable
     */
    private static function classExtractor(self $parameterExtractor): callable
    {
        return static fn (object $handler): ?string => $parameterExtractor->extract($handler);
    }

    /**
     * Returns a callable that transforms a given value into an array containing that value.
     * This is used to ensure consistent return types for processing.
     *
     * @return callable a function that takes a mixed value and returns an array containing that value
     */
    private static function unflatten(): callable
    {
        return static fn (mixed $value): array => [$value];
    }

    /**
     * Extracts the type of the first parameter from the `__invoke` method of a given class.
     *
     * @param object $class the object from which to extract the first parameter type of its `__invoke` method
     *
     * @return ?string the class name of the first parameter, or null if it cannot be determined
     * @throws \ReflectionException
     */
    public function extract(object $class): ?string
    {
        $reflector = new \ReflectionClass($class);
        $method = $reflector->getMethod('__invoke');

        if ($this->hasOnlyOneParameter($method)) {
            return $this->firstParameterClassFrom($method);
        }

        return null;
    }

    /**
     * Retrieves the class name of the first parameter from a given ReflectionMethod.
     *
     * @param \ReflectionMethod $method the method from which to extract the first parameter's class name
     *
     * @return string the class name of the first parameter
     *
     * @throws \LogicException if there is no type hint for the first parameter
     */
    private function firstParameterClassFrom(\ReflectionMethod $method): string
    {
        $firstParameterType = $method->getParameters()[0]->getType();

        if (null === $firstParameterType) {
            throw new \LogicException('Missing type hint for the first parameter of __invoke');
        }

        return $firstParameterType->getName();
    }

    /**
     * Checks if a given ReflectionMethod has exactly one parameter.
     *
     * @param \ReflectionMethod $method the method to check
     *
     * @return bool true if the method has exactly one parameter, false otherwise
     */
    private function hasOnlyOneParameter(\ReflectionMethod $method): bool
    {
        return 1 === $method->getNumberOfParameters();
    }
}
