<?php

namespace SnappMarketPro\Moadian;

use DateTime;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnappMarketPro\Moadian\Api\Api;
use SnappMarketPro\Moadian\Dto\Packet;
use SnappMarketPro\Moadian\Dto\Token;
use SnappMarketPro\Moadian\Services\EncryptionService;
use SnappMarketPro\Moadian\Services\HttpClient;
use SnappMarketPro\Moadian\Services\InvoiceIdService;
use SnappMarketPro\Moadian\Services\SignatureService;

class Moadian
{
    private Token $token;

    public function __construct(
        protected string $publicKey,
        protected string $privateKey,
        protected string $orgKeyId,
        protected string $username,
        protected string $baseURL = 'https://tp.tax.gov.ir',
    )
    {
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @throws GuzzleException
     */
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

    /**
     * @throws GuzzleException
     */
    public function getToken(): Token
    {
        $signatureService = new SignatureService($this->privateKey);

        $encryptionService = new EncryptionService($this->orgKeyId, null);

        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);

        $api = new Api($this->username, $httpClient);

        return $api->getToken();
    }

    /**
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function inquiryByReferenceNumber(string $referenceNumber): array
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->inquiryByReferenceNumber($referenceNumber);
    }

    /**
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getEconomicCodeInformation(string $taxID): array
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->getEconomicCodeInformation($taxID);
    }

    /**
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getFiscalInfo(): array
    {
        $signatureService = new SignatureService($this->privateKey);
        $encryptionService = new EncryptionService($this->orgKeyId, null);
        $httpClient = new HttpClient($this->baseURL, $signatureService, $encryptionService);
        $api = new Api($this->username, $httpClient);
        $api->setToken($this->token);
        return $api->getFiscalInfo();
    }

    public function generateTaxId(DateTime $invoiceCreatedAt, $internalInvoiceId): string
    {
        $invoiceIdService = new InvoiceIdService($this->username);

        return $invoiceIdService->generateInvoiceId($invoiceCreatedAt, $internalInvoiceId);
    }
}
