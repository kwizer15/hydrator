<?php

declare(strict_types=1);

namespace Kwizer\Hydrator;

/**
 * Hydrator
 */
class Hydrator implements HydratorInterface
{
    private $reflections = [];

    private $methods = [];

    /**
     * Hydrate un objet
     *
     * @param object|string $destination Object or class name to hydrate
     * @param array|object $source Data source
     * @return object Hydrated object
     */
    public function hydrate($destination, $source)
    {
        $destination = $this->getDestinationToObject($destination);
        $source = $this->getSourceToArray($source);

        foreach ($source as $property => $value) {
            $destination = $this->hydrateProperty($destination, $property, $value);
        }
        return $destination;
    }

    private function hydrateProperty($destination, string $property, $value)
    {
        if ($this->hasWitherForProperty($destination, $property)) {
            $method = $this->getWither($property);
            $destination = $destination->{$method}($value);
            return $destination;
        }
        if ($this->hasSetterForProperty($destination, $property)) {
            $method = $this->getSetter($property);
            $destination->{$method}($value);
            return $destination;
        }
        $reflectedProperty = new \ReflectionProperty(\get_class($destination), $property);
        if ($reflectedProperty->isPublic()) {
            $destination->$property = $value;
        }
        $reflectedProperty->setAccessible(true);
        $reflectedProperty->setValue($destination, $value);
        return $destination;
    }

    private function getDestinationToObject($destination)
    {
        if (\is_string($destination)) {
            $destination = $this->getNewInstanceOf($destination);
        }
        if (!\is_object($destination)) {
            throw new HydratationException('Destination must be an object or the class name as string.');
        }
        return $destination;
    }

    private function getSourceToArray($source): array
    {
        if (\is_object($source)) {
            $source = $this->extractPropertiesToArray($source);
        }
        if (!\is_array($source)) {
            throw new HydratationException('Data source must be an object or an array.');
        }
        return $source;
    }

    private function getNewInstanceOf(string $destination)
    {
        $reflector = $this->getReflectionClass($destination);
        return $reflector->newInstanceWithoutConstructor();
    }

    private function getReflectionClass($class): \ReflectionClass
    {
        $className = (\is_object($class)) ? \get_class($class) : $class;
        if (!\array_key_exists($className, $this->reflections)) {
            $this->reflections[$className] = new \ReflectionClass($class);
        }
        return $this->reflections[$className];
    }

    private function hasSetterForProperty($destination, $property)
    {
        return \method_exists($destination, $this->getSetter($property));
    }

    private function hasWitherForProperty($destination, $property)
    {
        return \method_exists($destination, $this->getWither($property));
    }
    
    private function getSetter($property): string
    {
        return $this->getMethod('set', $property);
    }

    private function getWither($property): string
    {
        return $this->getMethod('with', $property);
    }

    private function getMethod($type, $property): string
    {
        if (!\array_key_exists($type, $this->methods)) {
            $this->methods[$type] = [];
        }
        if (!\array_key_exists($property, $this->methods[$type])) {
            $this->methods[$type][$property] = $type . \ucfirst($property);
        }
        return $this->methods[$type][$property];
    }

    private function extractPropertiesToArray($source)
    {
        $reflectedClass = $this->getReflectionClass($source);
        $reflectedProperties = $reflectedClass->getProperties();
        $properties = \get_object_vars($source);
        foreach ($reflectedProperties as $reflectedProperty) {
            $properties[$reflectedProperty->getName()] = $reflectedProperty->getValue($source);
        }
        return $properties;
    }
}
