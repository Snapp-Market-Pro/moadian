<?php

namespace Arissystem\Moadian\Services;

class VerhoeffService
{
    private const MULTIPLICATION_TABLE = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
        [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
        [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
        [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
        [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
        [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
        [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
        [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
        [9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    ];

    private const PERMUTATION_TABLE = [
        [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
        [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
        [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
        [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
        [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
        [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
        [7, 0, 4, 6, 9, 1, 3, 2, 5, 8],
    ];

    private const INVERSE_TABLE = [0, 4, 3, 2, 1, 5, 6, 7, 8, 9];

    public static function checkSum($number): int
    {
        $c = 0;
        $len = strlen($number);

        for ($i = 0; $i < $len; ++$i)
            $c = self::MULTIPLICATION_TABLE[$c][self::PERMUTATION_TABLE[(($i + 1) % 8)][$number[$len - $i - 1] - '0']];

        return self::INVERSE_TABLE[$c];
    }

    public static function validate($number): bool
    {
        $c = 0;
        $len = strlen($number);

        for ($i = 0; $i < $len; ++$i)
            $c = self::MULTIPLICATION_TABLE[$c][self::PERMUTATION_TABLE[($i % 8)][$number[$len - $i - 1] - '0']];

        return $c == 0;
    }
}
