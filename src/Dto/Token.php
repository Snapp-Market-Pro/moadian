<?php

namespace Arissystem\Moadian\Dto;

class Token
{
    private string $token;
        private int $expiresAt;

    public function __construct(string $token, int $expiresAt)
    {
        $this->token = $token;
        $this->expiresAt = $expiresAt;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    public function isExpired(): int
    {
        return ((int) floor(microtime(true) * 1000)) >= ($this->expiresAt - 100 * 1000);
    }
}
