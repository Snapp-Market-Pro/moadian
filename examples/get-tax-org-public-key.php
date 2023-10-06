<?php

$username = 'A1A2B3';
$taxOrgPublicKey = '';
$privateKey = '';
$taxOrgKeyId = '';
$baseURL = 'https://sandboxrc.tax.gov.ir/';

$moadian = new \SnappMarketPro\Moadian\Moadian(
    $taxOrgPublicKey,
    $privateKey,
    $taxOrgKeyId,
    $username,
    $baseURL
);

$response = $moadian->getServerInformation();

/*
Response looks something like this:
{
    "signature": null,
    "signatureKeyId": null,
    "timestamp": 11111111111,
    "result": {
        "uid": "XXXX",
        "packetType": "SERVER_INFORMATION",
        "data": {
            "serverTime": 11111111111,
            "publicKeys": [
                {
                    "key": "XXXX",
                    "id": "XXXX",
                    "algorithm": "RSA",
                    "purpose": 1
                }
            ]
        },
        "encryptionKeyId": null,
        "symmetricKey": null,
        "iv": null
    }
}
*/


// Now you should store this public key in some file and use it whenever you want to interact with moadian API.
// No need to this every request, doing it once should be fine until they change server public key, which is unlikely.
// Also save the key ID in some config or env file and pass it to Moadian class from now on.

// You can use this code to store it in pem format
$publicKey = $response['result']['data']['publicKeys'][0]['key'];
$file = fopen("public.key", 'w+');
fwrite($file, "-----BEGIN PUBLIC KEY-----\n");
fwrite($file, chunk_split($publicKey, 64, "\n"));
fwrite($file, "-----END PUBLIC KEY-----\n");
fclose($file);