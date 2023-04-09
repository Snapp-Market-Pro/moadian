<?php

namespace Arissystem\Moadian\Dto;

class InvoicePaymentDto extends PrimitiveDto
{

    /**
     * Iin number
     */
    private ?string $iinn;

    /**
     * acceptor number
     */
    private ?string $acn;

    /**
     * terminal number
     */
    private ?string $trmn;

    /**
     * tracking number
     */
    private ?string $trn;

    /**
     * payer card number
     */
    private ?string $pcn;

    /**
     * payer ID
     */
    private ?string $pid;

    private ?int $pmt;

    /**
     * payment DateTime
     */
    private ?int $pdt;

    public function getIinn(): ?string
    {
        return $this->iinn;
    }

    public function setIinn(?string $iinn): self
    {
        $this->iinn = $iinn;
        return $this;
    }

    public function getAcn(): ?string
    {
        return $this->acn;
    }

    public function setAcn(?string $acn): self
    {
        $this->acn = $acn;
        return $this;
    }

    public function getTrmn(): ?string
    {
        return $this->trmn;
    }

    public function setTrmn(?string $trmn): self
    {
        $this->trmn = $trmn;
        return $this;
    }

    public function getTrn(): ?string
    {
        return $this->trn;
    }

    public function setTrn(?string $trn): self
    {
        $this->trn = $trn;
        return $this;
    }

    public function getPcn(): ?string
    {
        return $this->pcn;
    }

    public function setPcn(?string $pcn): self
    {
        $this->pcn = $pcn;
        return $this;
    }

    public function getPid(): ?string
    {
        return $this->pid;
    }

    public function setPid(?string $pid): self
    {
        $this->pid = $pid;
        return $this;
    }

    public function getPdt(): ?int
    {
        return $this->pdt;
    }

    public function setPdt(?int $pdt): self
    {
        $this->pdt = $pdt;
        return $this;
    }


    public function getPmt(): ?int
    {
        return $this->pmt;
    }

    public function setPmt(?int $pmt): self
    {
        $this->pmt = $pmt;
        return $this;
    }
}
