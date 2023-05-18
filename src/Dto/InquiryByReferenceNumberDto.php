<?php

namespace SnappMarketPro\Moadian\Dto;

class InquiryByReferenceNumberDto extends PrimitiveDto
{
    private array $referenceNumber;

    public function setReferenceNumber(string $referenceNumber): void
    {
        $this->referenceNumber = [$referenceNumber];
    }

    public function getReferenceNumber(string $referenceNumber): array
    {
        return $this->referenceNumber;
    }
}