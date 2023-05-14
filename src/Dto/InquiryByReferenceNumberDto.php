<?php


namespace SnappMarketPro\Moadian\Dto;


class InquiryByReferenceNumberDto extends PrimitiveDto
{
    private $referenceNumber;

    public function setReferenceNumber(string $referenceNumber)
    {
        $this->referenceNumber = [$referenceNumber];
    }

    public function getReferenceNumber(string $referenceNumber)
    {
        return $this->referenceNumber;
    }
}