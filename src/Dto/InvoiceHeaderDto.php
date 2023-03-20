<?php

namespace SnappMarketPro\Moadian\Dto;

class InvoiceHeaderDto extends PrimitiveDto
{

    /**
     * invoiceDateTimeGregorian
     */
    private int $indati2m;

    /**
     * invoiceDateTime
     */
    private int $indatim;

    /**
     * invoiceType
     */
    private int $inty;

    /**
     * flightType
     */
    private ?int $ft;

    /**
     * invoiceNumber
     */
    private int $inno;

    /**
     * invoiceReferenceTaxId
     */
    private ?string $irtaxid;

    /**
     * sellerCustomsLicenceNumber
     */
    private ?int $scln;

    /**
     * settlementType
     */
    private int $setm;

    /**
     * sellerTaxIdentificationNumber
     */
    private ?string $tins;

    /**
     * cashPayment
     */
    private float $cap;

    /**
     * buyerId
     */
    private ?string $bid;

    /**
     * installmentPayment
     */
    private float $insp;

    /**
     * totalVatOfPayment
     */
    private float $tvop;

    /**
     * buyerPostalCode
     */
    private ?string $bpc;

    /**
     * buyerVatPaymentStatus
     */
    private ?int $dpvb;

    /**
     * tax17
     */
    private float $tax17;

    /**
     * taxId
     */
    private string $taxid;

    /**
     * invoicePattern
     */
    private int $inp;

    /**
     * sellerCustomsCode
     */
    private ?string $scc;

    /**
     * invoiceSubject
     */
    private int $ins;

    /**
     * billingId
     */
    private ?string $billid;

    /**
     * totalPreDiscount
     */
    private float $tprdis;

    /**
     * totalDiscount
     */
    private float $tdis;

    /**
     * totalAfterDiscount
     */
    private ?float $tadis;

    /**
     * totalVatAmount
     */
    private float $tvam;

    /**
     * totalOtherDutyAmount
     */
    private ?float $todam;

    /**
     * totalBill
     */
    private float $tbill;

    /**
     * typeOfBuyer
     */
    private ?int $tob;

    /**
     * buyerTaxIdentificationNumber
     */
    private ?string $tinb;

    /**
     * sellerBranchCode
     */
    private ?string $sbc;

    /**
     * buyerBranchCode
     */
    private ?string $bbc;

    /**
     * buyerPassportNumber
     */
    private ?string $bpn;

    /**
     * contractRegistrationNumber
     */
    private ?int $crn;

    public function getIndati2m(): int
    {
        return $this->indati2m;
    }

    public function setIndati2m(int $indati2m): InvoiceHeaderDto
    {
        $this->indati2m = $indati2m;
        return $this;
    }

    public function getIndatim(): int
    {
        return $this->indatim;
    }

    public function setIndatim(int $indatim): InvoiceHeaderDto
    {
        $this->indatim = $indatim;
        return $this;
    }

    public function getInty(): int
    {
        return $this->inty;
    }

    public function setInty(int $inty): InvoiceHeaderDto
    {
        $this->inty = $inty;
        return $this;
    }

    public function getFt(): int
    {
        return $this->ft;
    }

    public function setFt(?int $ft): InvoiceHeaderDto
    {
        $this->ft = $ft;
        return $this;
    }

    public function getInno(): string
    {
        return $this->inno;
    }

    public function setInno(int $inno): InvoiceHeaderDto
    {
        $this->inno = $inno;
        return $this;
    }

    public function getIrtaxid(): string
    {
        return $this->irtaxid;
    }

    public function setIrtaxid(?string $irtaxid): InvoiceHeaderDto
    {
        $this->irtaxid = $irtaxid;
        return $this;
    }

    public function getScln(): int
    {
        return $this->scln;
    }

    public function setScln(?int $scln): InvoiceHeaderDto
    {
        $this->scln = $scln;
        return $this;
    }

    public function getSetm(): int
    {
        return $this->setm;
    }

    public function setSetm(int $setm): InvoiceHeaderDto
    {
        $this->setm = $setm;
        return $this;
    }

    public function getTins(): ?string
    {
        return $this->tins;
    }

    public function setTins(?string $tins): InvoiceHeaderDto
    {
        $this->tins = $tins;
        return $this;
    }

    public function getCap(): float
    {
        return $this->cap;
    }

    public function setCap(float $cap): InvoiceHeaderDto
    {
        $this->cap = $cap;
        return $this;
    }

    public function getBid(): string
    {
        return $this->bid;
    }

    public function setBid(?string $bid): InvoiceHeaderDto
    {
        $this->bid = $bid;
        return $this;
    }

    public function getInsp(): float
    {
        return $this->insp;
    }

    public function setInsp(float $insp): InvoiceHeaderDto
    {
        $this->insp = $insp;
        return $this;
    }

    public function getTvop(): float
    {
        return $this->tvop;
    }

    public function setTvop(float $tvop): InvoiceHeaderDto
    {
        $this->tvop = $tvop;
        return $this;
    }

    public function getBpc(): string
    {
        return $this->bpc;
    }

    public function setBpc(?string $bpc): InvoiceHeaderDto
    {
        $this->bpc = $bpc;
        return $this;
    }

    public function getDpvb(): int
    {
        return $this->dpvb;
    }

    public function setDpvb(?int $dpvb): InvoiceHeaderDto
    {
        $this->dpvb = $dpvb;
        return $this;
    }

    public function getTax17(): float
    {
        return $this->tax17;
    }

    public function setTax17(float $tax17): InvoiceHeaderDto
    {
        $this->tax17 = $tax17;
        return $this;
    }

    public function getTaxid(): string
    {
        return $this->taxid;
    }

    public function setTaxid(string $taxid): InvoiceHeaderDto
    {
        $this->taxid = $taxid;
        return $this;
    }

    public function getInp(): int
    {
        return $this->inp;
    }

    public function setInp(int $inp): InvoiceHeaderDto
    {
        $this->inp = $inp;
        return $this;
    }

    public function getScc(): string
    {
        return $this->scc;
    }

    public function setScc(?string $scc): InvoiceHeaderDto
    {
        $this->scc = $scc;
        return $this;
    }

    public function getIns(): int
    {
        return $this->ins;
    }

    public function setIns(int $ins): InvoiceHeaderDto
    {
        $this->ins = $ins;
        return $this;
    }

    public function getBillid(): string
    {
        return $this->billid;
    }

    public function setBillid(?string $billid): InvoiceHeaderDto
    {
        $this->billid = $billid;
        return $this;
    }

    public function getTprdis(): float
    {
        return $this->tprdis;
    }

    public function setTprdis(float $tprdis): InvoiceHeaderDto
    {
        $this->tprdis = $tprdis;
        return $this;
    }

    public function getTdis(): float
    {
        return $this->tdis;
    }

    public function setTdis(float $tdis): InvoiceHeaderDto
    {
        $this->tdis = $tdis;
        return $this;
    }

    public function getTadis(): float
    {
        return $this->tadis;
    }

    public function setTadis(?float $tadis): InvoiceHeaderDto
    {
        $this->tadis = $tadis;
        return $this;
    }

    public function getTvam(): float
    {
        return $this->tvam;
    }

    public function setTvam(float $tvam): InvoiceHeaderDto
    {
        $this->tvam = $tvam;
        return $this;
    }

    public function getTodam(): ?float
    {
        return $this->todam;
    }

    public function setTodam(?float $todam): InvoiceHeaderDto
    {
        $this->todam = $todam;
        return $this;
    }

    public function getTbill(): float
    {
        return $this->tbill;
    }

    public function setTbill(float $tbill): InvoiceHeaderDto
    {
        $this->tbill = $tbill;
        return $this;
    }

    public function getTob(): int
    {
        return $this->tob;
    }

    public function setTob(?int $tob): InvoiceHeaderDto
    {
        $this->tob = $tob;
        return $this;
    }

    public function getTinb(): string
    {
        return $this->tinb;
    }

    public function setTinb(?string $tinb): InvoiceHeaderDto
    {
        $this->tinb = $tinb;
        return $this;
    }

    public function getSbc(): string
    {
        return $this->sbc;
    }

    public function setSbc(?string $sbc): InvoiceHeaderDto
    {
        $this->sbc = $sbc;
        return $this;
    }

    public function getBbc(): string
    {
        return $this->bbc;
    }

    public function setBbc(?string $bbc): InvoiceHeaderDto
    {
        $this->bbc = $bbc;
        return $this;
    }

    public function getBpn(): string
    {
        return $this->bpn;
    }

    public function setBpn(?string $bpn): InvoiceHeaderDto
    {
        $this->bpn = $bpn;
        return $this;
    }

    public function getCrn(): int
    {
        return $this->crn;
    }

    public function setCrn(?int $crn): InvoiceHeaderDto
    {
        $this->crn = $crn;
        return $this;
    }
}
