<?php

namespace Src\Dto;

class InvoiceBodyDto extends PrimitiveDto
{

    /**
     * service Stuff Id
     */
    private string $sstid;

    /**
     * serviceStuffTitle
     */
    private string $sstt;

    /**
     * measurementUnit
     */
    private string $mu;

    /**
     * amount
     */
    private float $am;

    /**
     * fee
     */
    private float $fee;

    /**
     * currencyFee
     */
    private ?float $cfee;

    /**
     * currencyType
     */
    private ?string $cut;

    /**
     * exchangeRate
     */
    private ?string $exr;

    /**
     * preDiscount
     */
    private float $prdis;

    /**
     * discount
     */
    private float $dis;

    /**
     * afterDiscount
     */
    private float $adis;

    /**
     * vatRate
     */
    private float $vra;

    /**
     * vatAmount
     */
    private float $vam;

    /**
     * overDutyTitle
     */
    private ?string $odt;

    /**
     * overDutyRate
     */
    private ?float $odr;

    /**
     * overDutyAmount
     */
    private ?float $odam;

    /**
     * otherLegalTitle
     */
    private ?string $olt;

    /**
     * otherLegalRate
     */
    private ?float $olr;

    /**
     * otherLegalAmount
     */
    private ?float $olam;

    /**
     * constructionFee
     */
    private ?float $consfee;

    /**
     * sellerProfit
     */
    private ?float $spro;

    /**
     * brokerSalary
     */
    private ?float $bros;

    /**
     * totalConstructionProfitBrokerSalary
     */
    private ?float $tcpbs;

    /**
     * cashOfPayment
     */
    private ?float $cop;

    /**
     * buyerSRegisterNumber
     */
    private ?string $bsrn;

    /**
     * vatOfPayment
     */
    private ?string $vop;

    /**
     * totalServiceStuffAmount
     */
    private float $tsstam;

    public function getSstid(): string
    {
        return $this->sstid;
    }

    public function setSstid(string $sstid): self
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

    public function getMu(): string
    {
        return $this->mu;
    }

    public function setMu(string $mu): self
    {
        $this->mu = $mu;
        return $this;
    }

    public function getAm(): float
    {
        return $this->am;
    }

    public function setAm(float $am): self
    {
        $this->am = $am;
        return $this;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function setFee(float $fee): self
    {
        $this->fee = $fee;
        return $this;
    }

    public function getCfee(): float
    {
        return $this->cfee;
    }

    public function setCfee(?float $cfee): self
    {
        $this->cfee = $cfee;
        return $this;
    }

    public function getCut(): string
    {
        return $this->cut;
    }

    public function setCut(?string $cut): self
    {
        $this->cut = $cut;
        return $this;
    }

    public function getExr(): string
    {
        return $this->exr;
    }

    public function setExr(?string $exr): self
    {
        $this->exr = $exr;
        return $this;
    }

    public function getPrdis(): float
    {
        return $this->prdis;
    }

    public function setPrdis(float $prdis): self
    {
        $this->prdis = $prdis;
        return $this;
    }

    public function getDis(): float
    {
        return $this->dis;
    }

    public function setDis(float $dis): self
    {
        $this->dis = $dis;
        return $this;
    }

    public function getAdis(): float
    {
        return $this->adis;
    }

    public function setAdis(float $adis): self
    {
        $this->adis = $adis;
        return $this;
    }

    public function getVra(): float
    {
        return $this->vra;
    }

    public function setVra(float $vra): self
    {
        $this->vra = $vra;
        return $this;
    }

    public function getVam(): float
    {
        return $this->vam;
    }

    public function setVam(float $vam): self
    {
        $this->vam = $vam;
        return $this;
    }

    public function getOdt(): string
    {
        return $this->odt;
    }

    public function setOdt(?string $odt): self
    {
        $this->odt = $odt;
        return $this;
    }

    public function getOdr(): float
    {
        return $this->odr;
    }

    public function setOdr(?float $odr): self
    {
        $this->odr = $odr;
        return $this;
    }

    public function getOdam(): float
    {
        return $this->odam;
    }

    public function setOdam(?float $odam): self
    {
        $this->odam = $odam;
        return $this;
    }

    public function getOlt(): string
    {
        return $this->olt;
    }

    public function setOlt(?string $olt): self
    {
        $this->olt = $olt;
        return $this;
    }

    public function getOlr(): float
    {
        return $this->olr;
    }

    public function setOlr(?float $olr): self
    {
        $this->olr = $olr;
        return $this;
    }

    public function getOlam(): float
    {
        return $this->olam;
    }

    public function setOlam(?float $olam): self
    {
        $this->olam = $olam;
        return $this;
    }

    public function getConsfee(): float
    {
        return $this->consfee;
    }

    public function setConsfee(?float $consfee): self
    {
        $this->consfee = $consfee;
        return $this;
    }

    public function getSpro(): float
    {
        return $this->spro;
    }

    public function setSpro(?float $spro): self
    {
        $this->spro = $spro;
        return $this;
    }

    public function getBros(): float
    {
        return $this->bros;
    }

    public function setBros(?float $bros): self
    {
        $this->bros = $bros;
        return $this;
    }

    public function getTcpbs(): float
    {
        return $this->tcpbs;
    }

    public function setTcpbs(?float $tcpbs): self
    {
        $this->tcpbs = $tcpbs;
        return $this;
    }

    public function getCop(): float
    {
        return $this->cop;
    }

    public function setCop(?float $cop): self
    {
        $this->cop = $cop;
        return $this;
    }

    public function getBsrn(): string
    {
        return $this->bsrn;
    }

    public function setBsrn(?string $bsrn): self
    {
        $this->bsrn = $bsrn;
        return $this;
    }

    public function getVop(): string
    {
        return $this->vop;
    }

    public function setVop(?string $vop): self
    {
        $this->vop = $vop;
        return $this;
    }

    public function getTsstam(): float
    {
        return $this->tsstam;
    }

    public function setTsstam(float $tsstam): self
    {
        $this->tsstam = $tsstam;
        return $this;
    }
}