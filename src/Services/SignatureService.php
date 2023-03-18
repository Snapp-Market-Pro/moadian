<?php

namespace Moaadian\Services;

use RuntimeException;

class SignatureService
{
    public function __construct(private string $privateKey, private string|null $keyId = null)
    {
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

    public function getKeyId(): string|null
    {
        return $this->keyId;
    }
}