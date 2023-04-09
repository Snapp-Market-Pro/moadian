<?php

namespace Arissystem\Moadian\Dto;

class InvoiceBodyDto extends PrimitiveDto
{
    /**
     * service stuff ID
     */
    private ?string $sstid;

    /**
     * service stuff title
     */
    private string $sstt;

    /**
     * amount
     */
    private int $am;

    /**
     * measurement unit
     */
    private string $mu;

    /**
     * fee (pure price per item)
     */
    private int $fee;

    /**
     * fee in foreign currency
     */
    private ?float $cfee;

    /**
     * currency type
     */
    private ?string $cut;

    /**
     * exchange rate
     */
    private ?int $exr;

    /**
     * pre discount
     */
    private int $prdis;

    /**
     * discount
     */
    private int $dis;

    /**
     * after discount
     */
    private int $adis;

    /**
     * VAT rate
     */
    private int $vra;

    /**
     * VAT amount
     */
    private int $vam;

    /**
     * over duty title
     */
    private ?string $odt;

    /**
     * over duty rate
     */
    private ?float $odr;

    /**
     * over duty amount
     */
    private ?int $odam;

    /**
     * other legal title
     */
    private ?string $olt;

    /**
     * other legal rate
     */
    private ?float $olr;

    /**
     * other legal amount
     */
    private ?int $olam;

    /**
     * construction fee
     */
    private ?int $consfee;

    /**
     * seller profit
     */
    private ?int $spro;

    /**
     * broker salary
     */
    private ?int $bros;

    /**
     * total construction profit broker salary
     */
    private ?int $tcpbs;

    /**
     * cash share of payment
     */
    private ?int $cop;

    /**
     * vat of payment
     */
    private ?string $vop;

    /**
     * buyer register number
     */
    private ?string $bsrn;

    /**
     * total service stuff amount
     */
    private int $tsstam;

    public function getSstid(): ?string
    {
        return $this->sstid;
    }

    public function setSstid(?string $sstid): self
    {
        $this->sstid = $sstid;
        return $this;
    }

    public function getSstt(): string
    {
        return $this->sstt;
    }

    public function setSstt(string $sstt): self
    {
        $this->sstt = $sstt;
        return $this;
    }

    public function getAm(): int
    {
        return $this->am;
    }

    public function setAm(int $am): self
    {
        $this->am = $am;
        return $this;
    }

    public function getMu(): string
    {
        return $this->mu;
    }

    public function setMu(string $mu): self
    {
        $this->mu = $mu;
        return $this;
    }

    public function getFee(): int
    {
        return $this->fee;
    }

    public function setFee(int $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function getCfee(): ?float
    {
        return $this->cfee;
    }

    public function setCfee(?float $cfee): self
    {
        $this->cfee = $cfee;
        return $this;
    }

    public function getCut(): ?string
    {
        return $this->cut;
    }

    public function setCut(?string $cut): self
    {
        $this->cut = $cut;
        return $this;
    }

    public function getExr(): ?int
    {
        return $this->exr;
    }

    public function setExr(?int $exr): self
    {
        $this->exr = $exr;
        return $this;
    }

    public function getPrdis(): int
    {
        return $this->prdis;
    }

    public function setPrdis(int $prdis): self
    {
        $this->prdis = $prdis;
        return $this;
    }

    public function getDis(): int
    {
        return $this->dis;
    }

    public function setDis(int $dis): self
    {
        $this->dis = $dis;
        return $this;
    }

    public function getAdis(): int
    {
        return $this->adis;
    }

    public function setAdis(int $adis): self
    {
        $this->adis = $adis;
        return $this;
    }

    public function getVra(): int
    {
        return $this->vra;
    }

    public function setVra(int $vra): self
    {
        $this->vra = $vra;
        return $this;
    }

    public function getVam(): int
    {
        return $this->vam;
    }

    public function setVam(int $vam): self
    {
        $this->vam = $vam;
        return $this;
    }

    public function getOdt(): ?string
    {
        return $this->odt;
    }

    public function setOdt(?string $odt): self
    {
        $this->odt = $odt;
        return $this;
    }

    public function getOdr(): ?float
    {
        return $this->odr;
    }

    public function setOdr(?float $odr): self
    {
        $this->odr = $odr;
        return $this;
    }

    public function getOdam(): ?int
    {
        return $this->odam;
    }

    public function setOdam(?int $odam): self
    {
        $this->odam = $odam;
        return $this;
    }

    public function getOlt(): ?string
    {
        return $this->olt;
    }

    public function setOlt(?string $olt): self
    {
        $this->olt = $olt;
        return $this;
    }

    public function getOlr(): ?int
    {
        return $this->olr;
    }

    public function setOlr(?float $olr): self
    {
        $this->olr = $olr;
        return $this;
    }

    public function getOlam(): ?float
    {
        return $this->olam;
    }

    public function setOlam(?int $olam): self
    {
        $this->olam = $olam;
        return $this;
    }

    public function getConsfee(): ?int
    {
        return $this->consfee;
    }

    public function setConsfee(?int $consfee): self
    {
        $this->consfee = $consfee;
        return $this;
    }

    public function getSpro(): ?int
    {
        return $this->spro;
    }

    public function setSpro(?int $spro): self
    {
        $this->spro = $spro;
        return $this;
    }

    public function getBros(): ?int
    {
        return $this->bros;
    }

    public function setBros(?int $bros): self
    {
        $this->bros = $bros;
        return $this;
    }

    public function getTcpbs(): ?int
    {
        return $this->tcpbs;
    }

    public function setTcpbs(?int $tcpbs): self
    {
        $this->tcpbs = $tcpbs;
        return $this;
    }

    public function getCop(): ?int
    {
        return $this->cop;
    }

    public function setCop(?int $cop): self
    {
        $this->cop = $cop;
        return $this;
    }

    public function getVop(): ?string
    {
        return $this->vop;
    }

    public function setVop(?string $vop): self
    {
        $this->vop = $vop;
        return $this;
    }

    public function getBsrn(): ?string
    {
        return $this->bsrn;
    }

    public function setBsrn(?string $bsrn): self
    {
        $this->bsrn = $bsrn;
        return $this;
    }

    public function getTsstam(): int
    {
        return $this->tsstam;
    }

    public function setTsstam(int $tsstam): self
    {
        $this->tsstam = $tsstam;
        return $this;
    }
}
