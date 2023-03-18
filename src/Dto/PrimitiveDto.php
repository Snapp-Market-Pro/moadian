<?php

namespace Src\Dto;

abstract class PrimitiveDto
{
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);

        $properties = $reflection->getProperties();

        $array = [];

        foreach ($properties as $property) {
            if ($property->isInitialized($this)) {
                $array[$property->getName()] = (string) $property->getValue($this);
            }
        }

        return $array;
    }
}