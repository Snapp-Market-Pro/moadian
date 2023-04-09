<?php

namespace Arissystem\Moadian\Services;

use Arissystem\Moadian\Constants\TransferConstants;

class SimpleNormalizer
{
    /**
     * @param string $data JSON string
     * @param string[] $headers
     */
    public function normalize(string $data, array $headers): string
    {
        if (empty($headers)) {
            return $data;
        }

        if (array_key_exists(TransferConstants::AUTHORIZATION_HEADER, $headers)) {
            $data .= $headers[TransferConstants::AUTHORIZATION_HEADER];
        }

        if (array_key_exists(TransferConstants::REQUEST_TRACE_ID_HEADER, $headers)) {
            $data .= $headers[TransferConstants::REQUEST_TRACE_ID_HEADER];
        }

        if (array_key_exists(TransferConstants::TIMESTAMP_HEADER, $headers)) {
            $data .= $headers[TransferConstants::TIMESTAMP_HEADER];
        }

        return $data;
    }
}
