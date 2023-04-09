<?php

namespace Arissystem\Moadian\Tests;

use DateTime;
use Monolog\Test\TestCase;
use Arissystem\Moadian\Services\InvoiceIdService;

class InvoiceIdGenerationTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function testItCanGenerateInvoiceId(
        string $clientId,
        DateTime $dateTime,
        int $internalInvoiceId,
        string $expected
    ): void {
        $invoiceIdService = new InvoiceIdService($clientId);
        $generatedInvoiceId = $invoiceIdService->generateInvoiceId($dateTime, $internalInvoiceId);
        $this->assertEquals($expected, $generatedInvoiceId);
    }

    public static function dataProvider(): array
    {
        return [
            ['DEF5GH', new DateTime('2020-07-20 01:00:10'), 12, 'DEF5GH0481F000000000C2'],
            ['DEF5GH', new DateTime('2020-07-20 08:30:30'), 8173, 'DEF5GH0481F0000001FED8'],
            ['DEF5GH', new DateTime('2020-07-20 23:11:12'), 2572613409, 'DEF5GH0481F009956F7211'],
        ];
    }
}