<?php

namespace App\DTO;

abstract class AbstractDTO
{
    public int $id;

    public static function fromArray(array $data): static
    {
        $instance = new static();

        foreach ($data as $property => $value) {
            if (property_exists($instance, $property)) {
                $instance->{$property} = $value;
            }
        }

        return $instance;
    }
}
