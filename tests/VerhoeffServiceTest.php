<?php

namespace Arissystem\Moadian\Tests;

use PHPUnit\Framework\TestCase;
use Arissystem\Moadian\Services\VerhoeffService;

class VerhoeffServiceTest extends TestCase
{
    /**
     * @test
     * @param string $number
     * @param int $expectedChecksum
     * @return void
     * @dataProvider rawNumberProvider
     */
    public function testItCanGenerateChecksum(string $number, int $expectedChecksum): void
    {
        $this->assertEquals($expectedChecksum, VerhoeffService::checkSum($number));
    }

    /**
     * @test
     * @param string $number
     * @param bool $correct
     * @return void
     * @dataProvider checkedNumberProvider
     */
    public function testItCanValidateCheckedNumbers(string $number, bool $correct): void
    {
        $this->assertEquals($correct, VerhoeffService::validate($number));
    }

    public static function rawNumberProvider(): array
    {
        return [
            ['68697057172018463000000000012', 2],
            ['68697057172018463000000008173', 8],
            ['68697057172018463002572613409', 1],
        ];
    }

    public static function checkedNumberProvider(): array
    {
        return [
            ['686970571720184630000000000122', true],
            ['686970571720184630000000081737', false],
            ['686970571720184630025726134092', false],
        ];
    }
}