<?php

// This is your company's tax ID (شناسه مالیاتی)
$taxId = '12345678901';
// You got this when you uploaded your public key to moadian
$username = 'A1B2C3';
// See the get-tax-org-public-key.php example
$taxOrgPublicKey = file_get_contents('moadian-public.key');
// See the get-tax-org-public-key.php example
$taxOrgKeyId = 'XXXX-XXXX-XXXX-XXXX';
// This is your private key, you have previously uploaded its corresponding public key to moadian
$privateKey = file_get_contents('private.key');
// Base URL for moadian API. For production, it is the default value for baseUrl parameter in Moadian class constructor
$baseUrl = 'https://sandboxrc.tax.gov.ir/';

$moadian = new \SnappMarketPro\Moadian\Moadian(
    $taxOrgPublicKey,
    $privateKey,
    $taxOrgKeyId,
    $username,
    $baseUrl
);

$invoice1InternalId = 1;
$invoice1DateTime = (new DateTime())->sub(new DateInterval('P10D'));
$invoice1Header = (new \SnappMarketPro\Moadian\Dto\InvoiceHeaderDto())
    ->setTaxid($moadian->generateTaxId($invoice1DateTime, $invoice1InternalId))
    ->setIndati2m($invoice1DateTime->getTimestamp() * 1000)
    ->setIndatim($invoice1DateTime->getTimestamp() * 1000)
    ->setInty(2)
    ->setInno($moadian->normalizeInvoiceNumber($invoice1InternalId))
    ->setIrtaxid(null)
    ->setInp(1)
    ->setIns(1)
    ->setTins($taxId)
    ->setTob(1)
    ->setBid(null)
    ->setTinb(null)
    ->setSbc(null)
    ->setBpc(null)
    ->setBbc(null)
    ->setFt(null)
    ->setBpn(null)
    ->setScln(null)
    ->setScc(null)
    ->setCrn(null)
    ->setBillid(null)
    ->setTprdis(100_000)
    ->setTdis(0)
    ->setTadis(100_000)
    ->setTvam(9_000)
    ->setTodam(0)
    ->setTbill(109_000)
    ->setSetm(null)
    ->setCap(null)
    ->setInsp(null)
    ->setTvop(null)
    ->setTax17(0);
$invoice1BodyDto = (new \SnappMarketPro\Moadian\Dto\InvoiceBodyDto())
    ->setSstid('2720000166053') // You have to get product codes from moadian
    ->setSstt('اسپری پاک کننده سطوح')
    ->setAm(2)
    ->setMu('1627')
    ->setFee(50_000)
    ->setCfee(null)
    ->setCut(null)
    ->setExr(null)
    ->setPrdis(100_000)
    ->setDis(0)
    ->setAdis(100_000)
    ->setVra(9)
    ->setVam(9_000)
    ->setOdt(null)
    ->setOdr(null)
    ->setOdam(null)
    ->setOlt(null)
    ->setOlr(null)
    ->setOlam(null)
    ->setConsfee(null)
    ->setSpro(null)
    ->setBros(null)
    ->setTcpbs(null)
    ->setCop(null)
    ->setVop(null)
    ->setBsrn(null)
    ->setTsstam(109_000);
$invoice1PaymentDto = (new \SnappMarketPro\Moadian\Dto\InvoicePaymentDto())
    ->setIinn(null)
    ->setAcn(null)
    ->setTrmn(null)
    ->setTrn(null)
    ->setPcn(null)
    ->setPid(null)
    ->setPdt(null);
$invoice1Dto = new \SnappMarketPro\Moadian\Dto\InvoiceDto();
$invoice1Dto->setHeader($invoice1Header);
$invoice1Dto->setBody([$invoice1BodyDto]);
$invoice1Dto->setPayments([$invoice1PaymentDto]);

########################################################################################################################

$invoice2InternalId = 1;
$invoice2DateTime = (new DateTime())->sub(new DateInterval('P9D'));
$invoice2Header = (new \SnappMarketPro\Moadian\Dto\InvoiceHeaderDto())
    ->setTaxid($moadian->generateTaxId($invoice2DateTime, $invoice2InternalId))
    ->setIndati2m($invoice2DateTime->getTimestamp() * 1000)
    ->setIndatim($invoice2DateTime->getTimestamp() * 1000)
    ->setInty(2)
    ->setInno($moadian->normalizeInvoiceNumber($invoice2InternalId))
    ->setIrtaxid(null)
    ->setInp(1)
    ->setIns(1)
    ->setTins($taxId)
    ->setTob(1)
    ->setBid(null)
    ->setTinb(null)
    ->setSbc(null)
    ->setBpc(null)
    ->setBbc(null)
    ->setFt(null)
    ->setBpn(null)
    ->setScln(null)
    ->setScc(null)
    ->setCrn(null)
    ->setBillid(null)
    ->setTprdis(80_000)
    ->setTdis(0)
    ->setTadis(80_000)
    ->setTvam(7_200)
    ->setTodam(0)
    ->setTbill(87_200)
    ->setSetm(null)
    ->setCap(null)
    ->setInsp(null)
    ->setTvop(null)
    ->setTax17(0);
$invoice2BodyDto = (new \SnappMarketPro\Moadian\Dto\InvoiceBodyDto())
    ->setSstid('2720000001774') // You have to get product codes from moadian
    ->setSstt('اسمارتیز')
    ->setAm(2)
    ->setMu('1627')
    ->setFee(40_000)
    ->setCfee(null)
    ->setCut(null)
    ->setExr(null)
    ->setPrdis(80_000)
    ->setDis(0)
    ->setAdis(80_000)
    ->setVra(9)
    ->setVam(7_200)
    ->setOdt(null)
    ->setOdr(null)
    ->setOdam(null)
    ->setOlt(null)
    ->setOlr(null)
    ->setOlam(null)
    ->setConsfee(null)
    ->setSpro(null)
    ->setBros(null)
    ->setTcpbs(null)
    ->setCop(null)
    ->setVop(null)
    ->setBsrn(null)
    ->setTsstam(87_200);
$invoice2PaymentDto = (new \SnappMarketPro\Moadian\Dto\InvoicePaymentDto())
    ->setIinn(null)
    ->setAcn(null)
    ->setTrmn(null)
    ->setTrn(null)
    ->setPcn(null)
    ->setPid(null)
    ->setPdt(null);
$invoice2Dto = new \SnappMarketPro\Moadian\Dto\InvoiceDto();
$invoice2Dto->setHeader($invoice2Header);
$invoice2Dto->setBody([$invoice2BodyDto]);
$invoice2Dto->setPayments([$invoice2PaymentDto]);

########################################################################################################################

// Login first
$token = $moadian->login();
// Save the token for your future requests so that you don't have to login for every invoice
// Make sure you use the getExpiresAt to get a new token when your old token expires.
$moadian->setToken($token);

// Send the invoices
$response = $moadian->sendInvoices([$invoice1Dto, $invoice2Dto]);

/*
Response will look like this:
{
    "signature": null,
    "signatureKeyId": null,
    "timestamp": 1111111111,
    "result": [
        {
            "uid": "XXXX",
            "referenceNumber": "c1b111c1-b11e-11ad-111e-cbb1c1111111",
            "errorCode": null,
            "errorDetail": null
        },
        {
            "uid": "XXXX",
            "referenceNumber": "c2b222c2-b22e-22ad-222e-cbb2c2222222",
            "errorCode": null,
            "errorDetail": null
        }
    ]
}
*/

// save the uid and reference number for your invoices, you will need them for inquiries

// see the inquire-by-reference-numbers.php for how to inquire about your invoices