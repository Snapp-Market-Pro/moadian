<?php


namespace AlirezaA2F\Moadian\Dto;


class InquiryByUidDto extends PrimitiveDto
{
    private $uid;

    public function setUid(string $uid): void
    {
        $this->uid = [$uid];
    }

    public function getUid(string $uid)
    {
        return $this->uid;
    }
}