<?php

namespace Arissystem\Moadian\Services;

class Normalizer
{
    public static function normalizeArray(array $data): string
    {
        $flattened = self::flattenArray($data);

        ksort($flattened);

        return self::arrayToValueString($flattened);
    }

    private static function flattenArray(array $array): array {
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $flattened = self::flattenArray($value);

                $flattened = array_combine(
                    array_map(
                        fn ($nestedKey) => "$key.$nestedKey",
                        array_keys($flattened)
                    ),
                    array_values($flattened)
                );

                $result = array_merge($result, $flattened);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    private static function arrayToValueString(array $data): string
    {
        $textValues = [];

        foreach ($data as $value) {
            if (is_bool($value)) {
                $textValue = $value ? 'true' : 'false';
            } elseif ($value === '' || $value === null) {
                $textValue = '#';
            } else {
                $textValue = str_replace('#', '##', (string)$value);
            }

            $textValues[] = $textValue;
        }

        return implode('#', $textValues);
    }
}

