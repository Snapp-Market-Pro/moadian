<?php

namespace SnappMarketPro\Moadian\Dto;

class InquiryByReferenceNumberDto extends PrimitiveDto
{
    /**
     * @var string[]
     */
    private array $referenceNumbers;

    /**
     * @param string[] $referenceNumbers
     * @return $this
     */
    public function setReferenceNumbers(array $referenceNumbers): self
    {
        $this->referenceNumbers = $referenceNumbers;
        return $this;
    }

    /**
     * @param string $referenceNumber
     * @return $this
     */
    public function addReferenceNumber(string $referenceNumber): self
    {
        $this->referenceNumbers[] = $referenceNumber;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getReferenceNumbers(): array
    {
        return $this->referenceNumbers;
    }
}