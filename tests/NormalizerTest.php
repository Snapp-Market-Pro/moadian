<?php

namespace Arissystem\Moadian\Tests;

use PHPUnit\Framework\TestCase;
use Arissystem\Moadian\Services\Normalizer;

class NormalizerTest extends TestCase
{
    public function testItCanNormalizeFlatArray(): void
    {
        $data = [
            'K1' => 1,
            'K2' => '132',
            'K3' => 'ABC',
        ];

        $this->assertEquals(
            '1#132#ABC',
            Normalizer::normalizeArray($data)
        );
    }

    public function testItSortsBasedOnKeysAlphabetically(): void
    {
        $data = [
            'K3' => 'ABC',
            'K1' => 1,
            'K2' => '132',
        ];

        $this->assertEquals(
            '1#132#ABC',
            Normalizer::normalizeArray($data)
        );
    }

    public function testItFlattensAssocArrayAndSortsByKeys(): void
    {
        $data = [
            'KD' => 12.94,
            'KB' => 'ABC',
            'KA' => [
                'B' => 'FGB',
                'A' => '700',
            ],
        ];

        $this->assertEquals(
            '700#FGB#ABC#12.94',
            Normalizer::normalizeArray($data)
        );
    }

    public function testItFlattensArraysAndSortsByNumericKeys(): void
    {
        $data = [
            'KD' => 12.94,
            'KB' => 'ABC',
            'KA' => [
                [
                    'B' => 2,
                    'A' => 1
                ],
                [
                    'A' => 3,
                    'B' => 4,
                ]
            ],
        ];

        $this->assertEquals(
            '1#2#3#4#ABC#12.94',
            Normalizer::normalizeArray($data)
        );
    }

    public function testItCanNormalizeDocumentationSample(): void
    {
        $data = [
            'k2' => 'v1',
            'k4' => 'v2',
            'k3' => [
                'k1' => 'v4',
                'k5' => 'v5',
            ],
        ];

        $this->assertEquals(
            'v1#v4#v5#v2',
            Normalizer::normalizeArray($data)
        );
    }
}