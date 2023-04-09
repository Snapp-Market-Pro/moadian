<?php

namespace Arissystem\Moadian\Services;

use RuntimeException;

class SignatureService
{
    private string $privateKey;
    private ?string $keyId = null;

    public function __construct(string $privateKey, ?string $keyId = null)
    {
        $this->privateKey = $privateKey;
        $this->keyId = $keyId;
    }

    public function sign(string $text): string
    {
        $signature = '';

        if (openssl_sign($text, $signature, $this->privateKey, OPENSSL_ALGO_SHA256)) {
            return base64_encode($signature);
        } else {
            throw new RuntimeException('Failed to sign the text with message ' . openssl_error_string());
        }
    }

    public function getKeyId(): ?string
    {
        return $this->keyId;
    }
}
