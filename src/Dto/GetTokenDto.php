<?php

namespace Arissystem\Moadian\Dto;

class GetTokenDto extends PrimitiveDto implements PacketDataInterface
{
    public string $username;
    
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->username,
        ];
    }
}
