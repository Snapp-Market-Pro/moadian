<?php

namespace SnappMarketPro\Moadian\Dto;

class InquiryByUidDto extends PrimitiveDto
{
    private array $uid;

    public function setUid(string $uid): void
    {
        $this->uid = [$uid];
    }

    public function getUid(string $uid): array
    {
        return $this->uid;
    }
}