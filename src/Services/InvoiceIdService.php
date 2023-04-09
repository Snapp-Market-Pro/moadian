<?php

namespace Arissystem\Moadian\Services;

use DateTime;

class InvoiceIdService
{
    private string $clientId;

    private const CHARACTER_TO_NUMBER_CODING = [
        'A' => 65, 'B' => 66, 'C' => 67, 'D' => 68, 'E' => 69, 'F' => 70, 'G' => 71, 'H' => 72, 'I' => 73,
        'J' => 74, 'K' => 75, 'L' => 76, 'M' => 77, 'N' => 78, 'O' => 79, 'P' => 80, 'Q' => 81, 'R' => 82,
        'S' => 83, 'T' => 84, 'U' => 85, 'V' => 86, 'W' => 87, 'X' => 88, 'Y' => 89, 'Z' => 90,
    ];

    public function __construct(string $clientId)
    {
        $this->clientId = $clientId;
    }

    public function generateInvoiceId(DateTime $date, int $internalInvoiceId): string
    {
        $daysPastEpoch = $this->getDaysPastEpoch($date);
        $daysPastEpochPadded = str_pad($daysPastEpoch, 6, '0', STR_PAD_LEFT);
        $hexDaysPastEpochPadded = str_pad(dechex($daysPastEpoch), 5, '0', STR_PAD_LEFT);

        $numericClientId = $this->clientIdToNumber($this->clientId);

        $internalInvoiceIdPadded = str_pad($internalInvoiceId, 12, '0', STR_PAD_LEFT);
        $hexInternalInvoiceIdPadded = str_pad(dechex($internalInvoiceId), 10, '0', STR_PAD_LEFT);

        $decimalInvoiceId = $numericClientId . $daysPastEpochPadded . $internalInvoiceIdPadded;

        $checksum = VerhoeffService::checkSum($decimalInvoiceId);

        return strtoupper($this->clientId . $hexDaysPastEpochPadded . $hexInternalInvoiceIdPadded . $checksum);
    }

    private function getDaysPastEpoch(DateTime $date): int
    {
        return (int)($date->getTimestamp() / (3600 * 24));
    }

    private function clientIdToNumber(string $clientId): string
    {
        $result = '';
        foreach (str_split($clientId) as $char) {
            if (is_numeric($char)) {
                $result .= $char;
            } else {
                $result .= self::CHARACTER_TO_NUMBER_CODING[$char];
            }
        }

        return $result;
    }
}
