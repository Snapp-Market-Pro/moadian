<?php

namespace Src\Dto;

abstract class PrimitiveDto implements PacketDataInterface
{
    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            if ($property->isInitialized($this)) {
                $value = $property->getValue($this);
                $value = $property->getValue($this) instanceof PacketDataInterface ?
                    $property->getValue($this)->toArray() : $value;

                $array[$property->getName()] = $value;
            }
        }
        return $array;
    }
}