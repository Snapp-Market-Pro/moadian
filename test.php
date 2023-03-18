<?php

use Src\Api\Api;
use Src\Services\EncryptionService;
use Src\Services\HttpClient;
use Src\Services\SignatureService;
use Src\Services\InvoiceIdService;
use Ramsey\Uuid\Uuid;

require_once __DIR__ . '/vendor/autoload.php';

$username = 'username';
$orgKeyId = '6a2bcd88-a871-4245-a393-2843eafe6e02';
$privateKey = file_get_contents(__DIR__ . '/private.key');
$publicKey = file_get_contents(__DIR__ . '/public.key');

$signatureService = new SignatureService($privateKey, null);
$encryptionService = new EncryptionService($publicKey, $orgKeyId);
$invoiceIdService = new InvoiceIdService($username);
$myuuid = Uuid::uuid4();
$myuuid = (string)$myuuid;

$packets = [
    [
        "uid" => $myuuid,
        "packetType" => "INVOICE.V01",
        "retry" => false,
        "data" => [
            "header" => [
                "indati2m" => 1000000,
                "indatim" => 1000000,
                "inty" => 1,
                "ft" => null,
                "inno" => 2,
                "irtaxid" => null,
                "scln" => null,
                "setm" => 1,
                "tins" => "5555555555",
                "cap" => 100, //مبلغ پرداختی قبلی
                "bid" => null,
                "insp" => 100, //مبلغ پرداخنی نسیه
                "tvop" => 0,
                "bpc" => null,
                "dpvb" => null,
                "tax17" => 0,
                "taxid" => "",
                "inp" => 1,
                "scc" => null,
                "ins" => 3,
                "billid" => null,
                "tprdis" => 100, //مجموع مبلغ قبل از کسر تخفیف
                "tdis" => 0,
                "tadis" => null,
                "tvam" => 0,
                "todam" => 0,
                "tbill" => 0, // مجموع صورت حساب
                "tob" => null,
                "tinb" => null,
                "sbc" => null,
                "bbc" => null,
                "bpn" => null,
                "crn" => null
            ],
            "body" => [
                [
                    "sstid" => "1111111111",
                    "sstt" => "A",
                    "mu" => 23,
                    "am" => 2.0,
                    "fee" => 100,
                    "cfee" => null,
                    "cut" => null,
                    "exr" => null,
                    "prdis" => 100,
                    "dis" => 100,
                    "adis" => 0,
                    "vra" => 0,
                    "vam" => 0,
                    "odt" => null,
                    "odr" => null,
                    "odam" => null,
                    "olt" => null,
                    "olr" => null,
                    "olam" => null,
                    "consfee" => null,
                    "spro" => null,
                    "bros" => null,
                    "tcpbs" => null,
                    "cop" => null,
                    "bsrn" => null,
                    "vop" => null,
                    "tsstam" => 100
                ]
            ],
            "payments" => [
                [
                    "iinn" => "1131244211",
                    "acn" => "2131244212",
                    "trmn" => "3131244213",
                    "trn" => "4131244214",
                    "pcn" => null,
                    "pid" => null,
                    "pdt" => null
                ]
            ],
            "extension" => null
        ],
        "encryptionKeyId" => null,
        "symmetricKey" => null,
        "iv" => null,
        "fiscalId" => "$username",
        "dataSignature" => null,
    ]
];


$aesHex = bin2hex(random_bytes(32));
$ivHex = bin2hex(random_bytes(16));


$packetDataNormalized = \Src\Services\Normalizer::normalizeArray($packets[0]['data']);
$packetDataSignature = $signatureService->sign($packetDataNormalized);
$packets[0]['dataSignature'] = $packetDataSignature;
$packetDataEncrypted = $encryptionService->encrypt(json_encode($packets[0]['data']), hex2bin($aesHex), hex2bin($ivHex));

$packets[0]['iv'] = $ivHex;
$packets[0]['data'] = $packetDataEncrypted;
$packets[0]['encryptionKeyId'] = $encryptionService->getEncryptionKeyId();
$packets[0]['symmetricKey'] = $encryptionService->encryptAesKey(hex2bin($aesHex));

$headers = [
    'Authorization' => generateToken(),
    'requestTraceId' => (string)Uuid::uuid4(),
    'timestamp' => time() * 1000,
];
$normalized = \Src\Services\Normalizer::normalizeArray(
    array_merge(
        ['packets' => $packets],
        $headers
    )
);


$signature = $signatureService->sign($normalized);

$content = [
    'packets' => $packets,
    'signature' => $signature,
    'signatureKeyId' => null,
];

$headers['Authorization'] = 'Bearer ' . $headers['Authorization'];
$client = new \GuzzleHttp\Client();
//try {
$res = $client->post('https://tp.tax.gov.ir/req/api/self-tsp/async/normal-enqueue', [
    'body' => json_encode($content),
    'headers' => [...$headers, 'Content-Type' => 'application/json']
]);

//}catch ( Exception $e) {
//    dd($e->getResponse()->getBody()->getContents());
//}
dd($res->getBody()->getContents());


function generateToken()
{
    $clientId = 'username';
    $baseUri = 'https://tp.tax.gov.ir/';
    $privateKey = file_get_contents(__DIR__ . '/private.key');
    $orgKeyId = '6a2bcd88-a871-4245-a393-2843eafe6e02';

    $signatureService = new SignatureService($privateKey);
    $encryptionService = new EncryptionService($orgKeyId, null);
    $httpClient = new HttpClient($baseUri, $signatureService, $encryptionService);

    $api = new Api($clientId, $httpClient);

    return $api->getToken()->getToken();
}
