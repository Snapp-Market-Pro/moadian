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

$taxId = $moadian->generateTaxId(new DateTime(), 1)

$invoiceHeaderDto = new InvoiceHeaderDto();
$invoiceHeaderDto->setIndati2m(1000000);
$invoiceHeaderDto->setIndatim(1000000);
$invoiceHeaderDto->setInty(1);
$invoiceHeaderDto->setFt(null);
$invoiceHeaderDto->setInno(2);
$invoiceHeaderDto->setIrtaxid(null);
$invoiceHeaderDto->setScln(null);
$invoiceHeaderDto->setSetm(1);
$invoiceHeaderDto->setTins('5555555555');
$invoiceHeaderDto->setCap(100);
$invoiceHeaderDto->setBid(null);
$invoiceHeaderDto->setInsp(100);
$invoiceHeaderDto->setTvop(0);
$invoiceHeaderDto->setBpc(null);
$invoiceHeaderDto->setDpvb(null);
$invoiceHeaderDto->setTax17(0);
$invoiceHeaderDto->setTaxid($taxId);
$invoiceHeaderDto->setInp(1);
$invoiceHeaderDto->setScc(null);
$invoiceHeaderDto->setIns(3);
$invoiceHeaderDto->setBillid(null);
$invoiceHeaderDto->setTprdis(100);
$invoiceHeaderDto->setTdis(0);
$invoiceHeaderDto->setTadis(null);
$invoiceHeaderDto->setTvam(0);
$invoiceHeaderDto->setTodam(0);
$invoiceHeaderDto->setTbill(0);
$invoiceHeaderDto->setTob(null);
$invoiceHeaderDto->setTinb(null);
$invoiceHeaderDto->setSbc(null);
$invoiceHeaderDto->setBbc(null);
$invoiceHeaderDto->setBpn(null);
$invoiceHeaderDto->setCrn(null);


$invoiceBodyDto = new InvoiceBodyDto();
$invoiceBodyDto->setSstid('1111111111');
$invoiceBodyDto->setSstt('A');
$invoiceBodyDto->setMu(23);
$invoiceBodyDto->setAm('2');
$invoiceBodyDto->setFee('100');
$invoiceBodyDto->setCfee(null);
$invoiceBodyDto->setCut(null);
$invoiceBodyDto->setExr(null);
$invoiceBodyDto->setPrdis('100');
$invoiceBodyDto->setDis('100');
$invoiceBodyDto->setAdis('0');
$invoiceBodyDto->setVra('0');
$invoiceBodyDto->setVam('0');
$invoiceBodyDto->setOdt(null);
$invoiceBodyDto->setOdr(null);
$invoiceBodyDto->setOdam(null);
$invoiceBodyDto->setOlt(null);
$invoiceBodyDto->setOlr(null);
$invoiceBodyDto->setOlam(null);
$invoiceBodyDto->setConsfee(null);
$invoiceBodyDto->setSpro(null);
$invoiceBodyDto->setBros(null);
$invoiceBodyDto->setTcpbs(null);
$invoiceBodyDto->setCop(null);
$invoiceBodyDto->setBsrn(null);
$invoiceBodyDto->setVop(null);
$invoiceBodyDto->setTsstam('100');

$invoicePaymentDto = new InvoicePaymentDto();
$invoicePaymentDto->setIinn("1131244211");
$invoicePaymentDto->setAcn("2131244212");
$invoicePaymentDto->setTrmn("3131244213");
$invoicePaymentDto->setTrn("4131244214");
$invoicePaymentDto->setPcn(null);
$invoicePaymentDto->setPid(null);
$invoicePaymentDto->setPdt(null);

$invoiceDto = new InvoiceDto();
$invoiceDto->setHeader($invoiceHeaderDto);
$invoiceDto->setBody([$invoiceBodyDto]);
$invoiceDto->setPayments([$invoicePaymentDto]);

$packet = new Packet(PacketType::INVOICE_V01, $invoiceDto);
$packet->setFiscalId($username);
$packet->setDataSignature(null);
$packet->setEncryptionKeyId(null);
$packet->setIv(null);
$packet->setSymmetricKey(null);


$token = $moadian->getToken();

$invoice = $moadian
    ->setToken($token->getToken())
    ->sendInvoice($packet);
dd($invoice->getBody()->getContents());
```

