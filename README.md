# سامانه مودیان

کد PHP - لاراول

نظام پایانه‌های فروشگاهی و سامانه مودیان

## Installation

```bash
composer require snapp-market-pro/moadian
```

## Usage

```php
<?php

use SnappMarketPro\Moadian\Constants\PacketType;
use SnappMarketPro\Moadian\Dto\InvoiceBodyDto;
use SnappMarketPro\Moadian\Dto\InvoiceDto;
use SnappMarketPro\Moadian\Dto\InvoiceHeaderDto;
use SnappMarketPro\Moadian\Dto\InvoicePaymentDto;
use SnappMarketPro\Moadian\Dto\Packet;
use SnappMarketPro\Moadian\Moadian;
use Datetime;

require_once __DIR__ . '/vendor/autoload.php';

$username = 'شناسه یکتای مالیاتی';
$orgKeyId = '6a2bcd88-a871-4245-a393-2843eafe6e02';
$privateKey = file_get_contents(__DIR__ . '/private.key');
$publicKey = file_get_contents(__DIR__ . '/public.key');

$moadian = new Moadian(
    $publicKey,
    $privateKey,
    $orgKeyId,
    $username
);

$taxId = $moadian->generateTaxId(new DateTime(), 1);

$invoiceHeaderDto = (new InvoiceHeaderDto)
    ->setIndati2m(1000000)
    ->setIndatim(1000000)
    ->setInty(1)
    ->setFt(null)
    ->setInno(2)
    ->setIrtaxid(null)
    ->setScln(null)
    ->setSetm(1)
    ->setTins('5555555555')
    ->setCap(100)
    ->setBid(null)
    ->setInsp(100)
    ->setTvop(0)
    ->setBpc(null)
    ->setTax17(0)
    ->setTaxid($taxId)
    ->setInp(1)
    ->setScc(null)
    ->setIns(3)
    ->setBillid(null)
    ->setTprdis(100)
    ->setTdis(0)
    ->setTadis(null)
    ->setTvam(0)
    ->setTodam(0)
    ->setTbill(0)
    ->setTob(null)
    ->setTinb(null)
    ->setSbc(null)
    ->setBbc(null)
    ->setBpn(null)
    ->setCrn(null);


$invoiceBodyDto = (new InvoiceBodyDto)
    ->setSstid('1111111111')
    ->setSstt('A')
    ->setMu(23)
    ->setAm('2')
    ->setFee('100')
    ->setCfee(null)
    ->setCut(null)
    ->setExr(null)
    ->setPrdis('100')
    ->setDis('100')
    ->setAdis('0')
    ->setVra('0')
    ->setVam('0')
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
    ->setBsrn(null)
    ->setVop(null)
    ->setTsstam('100');

$invoicePaymentDto = (new InvoicePaymentDto)
    ->setIinn("1131244211")
    ->setAcn("2131244212")
    ->setTrmn("3131244213")
    ->setTrn("4131244214")
    ->setPcn(null)
    ->setPid(null)
    ->setPdt(null);

$invoiceDto = (new InvoiceDto)
    ->setHeader($invoiceHeaderDto)
    ->setBody([$invoiceBodyDto])
    ->setPayments([$invoicePaymentDto]);

$packet = (new Packet(PacketType::INVOICE_V01, $invoiceDto))
    ->setFiscalId($username)
    ->setDataSignature(null)
    ->setEncryptionKeyId(null)
    ->setIv(null)
    ->setSymmetricKey(null);


$token = $moadian->getToken();

$invoice = $moadian
    ->setToken($token->getToken())
    ->sendInvoice($packet);
dd($invoice->getBody()->getContents());
```

