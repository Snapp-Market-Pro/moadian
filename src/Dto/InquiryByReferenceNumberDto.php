<?php

namespace SnappMarketPro\Moadian\Dto;

class InquiryByReferenceNumberDto extends PrimitiveDto
{
    /** @var string[] */
    public array $referenceNumber;

    public function addReferenceNumber(string $referenceNumber): self
    {
        $this->referenceNumber = [$referenceNumber];
        return $this;
    }

    /** @param string[] $referenceNumber */
    public function setReferenceNumber(array $referenceNumber): self
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }

    /** @return string[] */
    public function getReferenceNumber(): array
    {
        return $this->referenceNumber;
    }
}
