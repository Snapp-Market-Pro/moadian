<?php

namespace SnappMarketPro\Moadian\Dto;

class Token
{
    public function __construct(
        private string $token,
        private int $expiresAt,
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function isExpired(): int
    {
        return ((int) floor(microtime(true) * 1000)) >= ($this->expiresAt - 100 * 1000);
    }
}
