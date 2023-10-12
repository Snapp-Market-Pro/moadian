<?php

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

// Login first
$token = $moadian->login();
// Save the token for your future requests so that you don't have to login for every inquiry
// Make sure you use the getExpiresAt to get a new token when your old token expires.
$moadian->setToken($token);

$referenceNumbers = ["c1b111c1-b11e-11ad-111e-cbb1c1111111", "c2b222c2-b22e-22ad-222e-cbb2c2222222"];

$response = $moadian->inquireByReferenceNumbers($referenceNumbers);

/*
Response will look like this:
{
    "signature": null,
    "signatureKeyId": null,
    "timestamp": 1111111111111,
    "result": {
        "uid": null,
        "packetType": "INQUIRY_RESULT",
        "data": [
            {
                "referenceNumber": "c1b111c1-b11e-11ad-111e-cbb1c1111111",
                "uid": "XXXX",
                "status": "FAILED",
                "data": {
                    "error": [
                        {
                            "code": "0301",
                            "message": "XXXX"
                        }
                    ],
                    "warning": [
                        {
                            "code": "1403",
                            "message": "XXXX"
                        }
                    ],
                    "success": false
                },
                "packetType": "receive_invoice_confirm",
                "fiscalId": "A1B2C3"
            },
            {
                "referenceNumber": "c2b222c2-b22e-22ad-222e-cbb2c2222222",
                "uid": "XXXX",
                "status": "SUCCESS",
                "data": {
                    "error": [],
                    "warning": [],
                    "success": true
                },
                "packetType": "receive_invoice_confirm",
                "fiscalId": "A1B2C3"
            }
        ],
        "encryptionKeyId": null,
        "symmetricKey": null,
        "iv": null
    }
}
*/