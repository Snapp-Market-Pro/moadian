<?php

namespace Moaadian\Dto;

use Ulid\Ulid;

class Packet
{
    private string $uid = '';

    private string $packetType = '';

    private bool $retry = false;

    private PacketDataInterface|string|null $data;

    private string $encryptionKeyId = '';

    private string $symmetricKey = '';

    private string $iv = '';

    private string $fiscalId = '';

    private string $dataSignature = '';

    private string|null $signatureKeyId = null;

    public function __construct(
        string $packetType,
        PacketDataInterface|string|null $data = null,
    ) {
        $this->packetType = $packetType;
        $this->data = $data;
        $this->uid = (string) Ulid::generate();
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;
        return $this;
    }

    public function getPacketType(): string
    {
        return $this->packetType;
    }

    public function setPacketType(string $packetType): self
    {
        $this->packetType = $packetType;
        return $this;
    }

    public function getRetry(): bool
    {
        return $this->retry;
    }

    public function setRetry(bool $retry): self
    {
        $this->retry = $retry;
        return $this;
    }

    public function getData(): PacketDataInterface|string|null
    {
        return $this->data;
    }

    public function setData(PacketDataInterface|string|null $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getEncryptionKeyId(): string
    {
        return $this->encryptionKeyId;
    }

    public function setEncryptionKeyId(string $encryptionKeyId): self
    {
        $this->encryptionKeyId = $encryptionKeyId;
        return $this;
    }

    public function getSymmetricKey(): string
    {
        return $this->symmetricKey;
    }

    public function setSymmetricKey(string $symmetricKey): self
    {
        $this->symmetricKey = $symmetricKey;
        return $this;
    }

    public function getIv(): string
    {
        return $this->iv;
    }

    public function setIv(string $iv): self
    {
        $this->iv = $iv;
        return $this;
    }

    public function getFiscalId(): string
    {
        return $this->fiscalId;
    }

    public function setFiscalId(string $fiscalId): self
    {
        $this->fiscalId = $fiscalId;
        return $this;
    }

    public function getDataSignature(): string
    {
        return $this->dataSignature;
    }

    public function setDataSignature(string $dataSignature): self
    {
        $this->dataSignature = $dataSignature;
        return $this;
    }

    public function getSignatureKeyId(): string|null
    {
        return $this->signatureKeyId;
    }

    public function setSignatureKeyId(string|null $signatureKeyId): self
    {
        $this->signatureKeyId = $signatureKeyId;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'packetType' => $this->packetType,
            'retry' => $this->retry,
            'data' => is_string($this->data) ? $this->data : $this->data?->toArray(),
            'encryptionKeyId' => $this->encryptionKeyId,
            'symmetricKey' => $this->symmetricKey,
            'iv' => $this->iv,
            'fiscalId' => $this->fiscalId,
            'dataSignature' => $this->dataSignature,
        ];

        if ($this->signatureKeyId) {
            $array['signatureKeyId'] = $this->signatureKeyId;
        }
    }
}