<?php

namespace AlirezaA2F\Moadian;

use DateTime;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use AlirezaA2F\Moadian\Api\Api;
use AlirezaA2F\Moadian\Dto\Packet;
use AlirezaA2F\Moadian\Dto\Token;
use AlirezaA2F\Moadian\Services\EncryptionService;
use AlirezaA2F\Moadian\Services\HttpClient;
use AlirezaA2F\Moadian\Services\InvoiceIdService;
use AlirezaA2F\Moadian\Services\SignatureService;

class Moadian
{
    private Token $token;

    public function __construct(
        protected readonly string $publicKey,
        protected readonly string $privateKey,
        protected readonly string $orgKeyId,
        protected readonly string $username,
        protected readonly string $baseURL = 'https://tp.tax.gov.ir',
    )
    {
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function sendInvoice(Packet $packet): ResponseInterface
    {
        if (!$this->token) {
            throw new InvalidArgumentException("Set token before sending invoice!");
        }

        $headers = [
            'Authorization' => 'Bearer ' . $this->token->getToken(),
            'requestTraceId' => (string)Uuid::uuid4(),
            'timestamp' => time() * 1000,
        ];

        $httpClient = new HttpClient($this->baseURL,
            new SignatureService($this->privateKey),
            new EncryptionService($this->publicKey, $this->orgKeyId)
        );

        $path = 'req/api/self-tsp/async/normal-enqueue';

        return $httpClient->sendPackets($path, [$packet], $headers, true, true);
    }

    public function getToken(): Token
    {
        $signatureService = new SignatureService($this->privateKey);

        $encryptionService = new EncryptionService($this->orgKeyId, null);

        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);

        $api = new Api($this->username, $httpClient);

        return $api->getToken();
    }

    public function generateTaxId(DateTime $invoiceCreatedAt, $internalInvoiceId): string
    {
        $invoiceIdService = new InvoiceIdService($this->username);

        return $invoiceIdService->generateInvoiceId($invoiceCreatedAt, $internalInvoiceId);
    }

    public function inquiryByReferenceNumber(string $referenceNumber)
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->inquiryByReferenceNumber($referenceNumber);
    }

    public function inquiryByUid(string $uid)
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->inquiryByUid($uid);
    }

    public function getEconomicCodeInformation(string $taxID)
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->getEconomicCodeInformation($taxID);
    }

    public function getFiscalInfo(): array
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->getFiscalInfo();
    }
}
