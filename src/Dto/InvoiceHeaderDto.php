<?php

namespace Arissystem\Moadian\Dto;

class InvoiceHeaderDto extends PrimitiveDto
{
    /**
     * unique tax ID (should be generated using InvoiceIdService)
     */
    private string $taxid;

    /**
     * invoice timestamp (milliseconds from epoch)
     */
    private int $indatim;

    /**
     * invoice creation timestamp (milliseconds from epoch)
     */
    private int $indati2m;

    /**
     * invoice type
     */
    private int $inty;

    /**
     * internal invoice number
     */
    private ?string $inno = null;

    /**
     * invoice reference tax ID
     */
    private ?string $irtaxid;

    /**
     * invoice pattern
     */
    private int $inp;

    /**
     * invoice subject
     */
    private int $ins;

    /**
     * seller tax identification number
     */
    private string $tins;

    /**
     * type of buyer
     */
    private ?int $tob;

    /**
     * buyer ID
     */
    private ?string $bid;

    /**
     * buyer tax identification number
     */
    private ?string $tinb;

    /**
     * seller branch code
     */
    private ?string $sbc;

    /**
     * buyer postal code
     */
    private ?string $bpc;

    /**
     * buyer branch code
     */
    private ?string $bbc;

    /**
     * flight type
     */
    private ?int $ft;

    /**
     * buyer passport number
     */
    private ?string $bpn;

    /**
     * seller customs licence number
     */
    private ?int $scln;

    /**
     * seller customs code
     */
    private ?string $scc;

    /**
     * contract registration number
     */
    private ?int $crn;

    /**
     * billing ID
     */
    private ?string $billid;

    /**
     * total pre discount
     */
    private int $tprdis;

    /**
     * total discount
     */
    private int $tdis;

    /**
     * total after discount
     */
    private int $tadis;

    /**
     * total VAT amount
     */
    private int $tvam;

    /**
     * total other duty amount
     */
    private int $todam;

    /**
     * total bill
     */
    private int $tbill;

    /**
     * settlement type
     */
    private ?int $setm;

    /**
     * cash payment
     */
    private ?int $cap;

    /**
     * installment payment
     */
    private ?int $insp;

    /**
     * total VAT of payment
     */
    private ?string $tvop;

    /**
     * tax17
     */
    private int $tax17;

    public function getTaxid(): string
    {
        return $this->taxid;
    }

    public function setTaxid(string $taxid): self
    {
        $this->taxid = $taxid;
        return $this;
    }

    public function getIndatim(): int
    {
        return $this->indatim;
    }

    public function setIndatim(int $indatim): self
    {
        $this->indatim = $indatim;
        return $this;
    }

    public function getIndati2m(): int
    {
        return $this->indati2m;
    }

    public function setIndati2m(int $indati2m): self
    {
        $this->indati2m = $indati2m;
        return $this;
    }

    public function getInty(): int
    {
        return $this->inty;
    }

    public function setInty(int $inty): self
    {
        $this->inty = $inty;
        return $this;
    }

    public function getInno(): ?string
    {
        return $this->inno;
    }

    public function setInno(?string $inno): self
    {
        $this->inno = $inno;
        return $this;
    }

    public function getIrtaxid(): ?string
    {
        return $this->irtaxid;
    }

    public function setIrtaxid(?string $irtaxid): self
    {
        $this->irtaxid = $irtaxid;
        return $this;
    }

    public function getInp(): int
    {
        return $this->inp;
    }

    public function setInp(int $inp): self
    {
        $this->inp = $inp;
        return $this;
    }

    public function getIns(): int
    {
        return $this->ins;
    }

    public function setIns(int $ins): self
    {
        $this->ins = $ins;
        return $this;
    }

    public function getTins(): string
    {
        return $this->tins;
    }

    public function setTins(string $tins): self
    {
        $this->tins = $tins;
        return $this;
    }

    public function getTob(): ?int
    {
        return $this->tob;
    }

    public function setTob(?int $tob): self
    {
        $this->tob = $tob;
        return $this;
    }

    public function getBid(): ?string
    {
        return $this->bid;
    }

    public function setBid(?string $bid): self
    {
        $this->bid = $bid;
        return $this;
    }

    public function getTinb(): ?string
    {
        return $this->tinb;
    }

    public function setTinb(?string $tinb): self
    {
        $this->tinb = $tinb;
        return $this;
    }

    public function getSbc(): ?string
    {
        return $this->sbc;
    }

    public function setSbc(?string $sbc): self
    {
        $this->sbc = $sbc;
        return $this;
    }

    public function getBpc(): ?string
    {
        return $this->bpc;
    }

    public function setBpc(?string $bpc): self
    {
        $this->bpc = $bpc;
        return $this;
    }

    public function getBbc(): ?string
    {
        return $this->bbc;
    }

    public function setBbc(?string $bbc): self
    {
        $this->bbc = $bbc;
        return $this;
    }

    public function getFt(): ?int
    {
        return $this->ft;
    }

    public function setFt(?int $ft): self
    {
        $this->ft = $ft;
        return $this;
    }

    public function getBpn(): ?string
    {
        return $this->bpn;
    }

    public function setBpn(?string $bpn): self
    {
        $this->bpn = $bpn;
        return $this;
    }

    public function getScln(): ?int
    {
        return $this->scln;
    }

    public function setScln(?int $scln): self
    {
        $this->scln = $scln;
        return $this;
    }

    public function getScc(): ?string
    {
        return $this->scc;
    }

    public function setScc(?string $scc): self
    {
        $this->scc = $scc;
        return $this;
    }

    public function getCrn(): ?int
    {
        return $this->crn;
    }

    public function setCrn(?int $crn): self
    {
        $this->crn = $crn;
        return $this;
    }

    public function getBillid(): ?string
    {
        return $this->billid;
    }

    public function setBillid(?string $billid): self
    {
        $this->billid = $billid;
        return $this;
    }

    public function getTprdis(): int
    {
        return $this->tprdis;
    }

    public function setTprdis(int $tprdis): self
    {
        $this->tprdis = $tprdis;
        return $this;
    }

    public function getTdis(): int
    {
        return $this->tdis;
    }

    public function setTdis(int $tdis): self
    {
        $this->tdis = $tdis;
        return $this;
    }

    public function getTadis(): int
    {
        return $this->tadis;
    }

    public function setTadis(int $tadis): self
    {
        $this->tadis = $tadis;
        return $this;
    }

    public function getTvam(): int
    {
        return $this->tvam;
    }

    public function setTvam(int $tvam): self
    {
        $this->tvam = $tvam;
        return $this;
    }

    public function getTodam(): int
    {
        return $this->todam;
    }

    public function setTodam(int $todam): self
    {
        $this->todam = $todam;
        return $this;
    }

    public function getTbill(): int
    {
        return $this->tbill;
    }

    public function setTbill(int $tbill): self
    {
        $this->tbill = $tbill;
        return $this;
    }

    public function getSetm(): ?int
    {
        return $this->setm;
    }

    public function setSetm(?int $setm): self
    {
        $this->setm = $setm;
        return $this;
    }

    public function getCap(): ?int
    {
        return $this->cap;
    }

    public function setCap(?int $cap): self
    {
        $this->cap = $cap;
        return $this;
    }

    public function getInsp(): ?int
    {
        return $this->insp;
    }

    public function setInsp(?int $insp): self
    {
        $this->insp = $insp;
        return $this;
    }

    public function getTvop(): ?string
    {
        return $this->tvop;
    }

    public function setTvop(?string $tvop): self
    {
        $this->tvop = $tvop;
        return $this;
    }

    public function getTax17(): int
    {
        return $this->tax17;
    }

    public function setTax17(int $tax17): self
    {
        $this->tax17 = $tax17;
        return $this;
    }
}