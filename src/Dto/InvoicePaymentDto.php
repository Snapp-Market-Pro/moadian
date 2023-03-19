<?php

namespace SnappMarketPro\Moadian\Dto;

class InvoicePaymentDto extends PrimitiveDto
{

    /**
     * IinNumber
     */
    private string $iinn;

    /**
     * acceptorNumber
     */
    private string $acn;

    /**
     * terminalNumber
     */
    private string $trmn;

    /**
     * trackingNumber
     */
    private string $trn;

    /**
     * payerCardNumber
     */
    private ?string $pcn;

    /**
     * payerId
     */
    private ?string $pid;

    /**
     * payDateTime
     */
    private ?int $pdt;

    public function getIinn(): string
    {
        return $this->iinn;
    }

    public function setIinn(string $iinn): self
    {
        $this->iinn = $iinn;
        return $this;
    }

    public function getAcn(): string
    {
        return $this->acn;
    }

    public function setAcn(string $acn): self
    {
        $this->acn = $acn;
        return $this;
    }

    public function getTrmn(): string
    {
        return $this->trmn;
    }

    public function setTrmn(string $trmn): self
    {
        $this->trmn = $trmn;
        return $this;
    }

    public function getTrn(): string
    {
        return $this->trn;
    }

    public function setTrn(string $trn): self
    {
        $this->trn = $trn;
        return $this;
    }

    public function getPcn(): string
    {
        return $this->pcn;
    }

    public function setPcn(?string $pcn): self
    {
        $this->pcn = $pcn;
        return $this;
    }

    public function getPid(): string
    {
        return $this->pid;
    }

    public function setPid(?string $pid): self
    {
        $this->pid = $pid;
        return $this;
    }

    public function getPdt(): int
    {
        return $this->pdt;
    }

    public function setPdt(?int $pdt): self
    {
        $this->pdt = $pdt;
        return $this;
    }
}
