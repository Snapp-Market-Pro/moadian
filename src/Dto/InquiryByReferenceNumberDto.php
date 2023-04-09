<?php

namespace Arissystem\Moadian\Dto;

class InquiryByReferenceNumberDto extends PrimitiveDto
{
    private array $referenceNumber;

    public function setReferenceNumber(string $referenceNumber)
    {
        $this->referenceNumber = [$referenceNumber];
    }

    public function getReferenceNumber(string $referenceNumber): array
    {
        return $this->referenceNumber;
    }
}