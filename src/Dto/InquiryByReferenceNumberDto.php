<?php


namespace AlirezaA2F\Moadian\Dto;


class InquiryByReferenceNumberDto extends PrimitiveDto
{
    private $referenceNumber;

    public function setReferenceNumber(string $referenceNumber): void
    {
        $this->referenceNumber = [$referenceNumber];
    }

    public function getReferenceNumber(string $referenceNumber)
    {
        return $this->referenceNumber;
    }
}