<?php

namespace SnappMarketPro\Moadian;

use DateTimeInterface;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use SnappMarketPro\Moadian\Constants\PacketType;
use SnappMarketPro\Moadian\Constants\TransferConstants;
use SnappMarketPro\Moadian\Dto\GetTokenDto;
use SnappMarketPro\Moadian\Dto\InquiryByReferenceNumberDto;
use SnappMarketPro\Moadian\Dto\InvoiceDto;
use SnappMarketPro\Moadian\Dto\Packet;
use SnappMarketPro\Moadian\Dto\Token;
use SnappMarketPro\Moadian\Services\EncryptionService;
use SnappMarketPro\Moadian\Services\HttpClient;
use SnappMarketPro\Moadian\Services\InvoiceIdService;
use SnappMarketPro\Moadian\Services\SignatureService;

class Moadian
{
    private string $username;
    private HttpClient $httpClient;
    private InvoiceIdService $invoiceIdService;
    private Token $token;

    public function __construct(
        string $taxOrgPublicKey,
        string $privateKey,
        string $taxOrgKeyId,
        string $username,
        string $baseURL = 'https://tp.tax.gov.ir',
    ) {
        $this->username = $username;

        $encryptionService = new EncryptionService($taxOrgPublicKey, $taxOrgKeyId);
        $signatureService = new SignatureService($privateKey);

        $this->httpClient = new HttpClient($baseURL, $signatureService, $encryptionService);
        $this->invoiceIdService = new InvoiceIdService($username);
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @deprecated User login method instead
     */
    public function getToken(array $headers = []): Token
    {
        return $this->login($headers);
    }

    /**
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @throws GuzzleException
     */
    public function login(array $headers = []): Token
    {
        $path = 'req/api/self-tsp/sync/' . PacketType::GET_TOKEN;

        $packet = new Packet(
            PacketType::GET_TOKEN,
            new GetTokenDto($this->username)
        );

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);

        $headers = $this->getEssentialHeaders($headers, false);

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        $body = json_decode($response->getBody()->getContents(), true);

        return new Token($body['result']['data']['token'], $body['result']['data']['expiresIn']);
    }

    /**
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @throws GuzzleException
     * @deprecated Use sendInvoices method instead which accepts an array of Invoice DTOs and sends them all at once
     */
    public function sendInvoice(Packet $packet, array $headers = []): ResponseInterface
    {
        $this->tokenIsRequired();

        $path = 'req/api/self-tsp/async/normal-enqueue';

        $headers = $this->getEssentialHeaders($headers);

        return $this->httpClient->sendPackets($path, [$packet], $headers, true, true);
    }

    /**
     * @param InvoiceDto[] $invoices
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function sendInvoices(array $invoices, array $headers = []): array
    {
        $this->tokenIsRequired();

        $path = 'req/api/self-tsp/async/normal-enqueue';

        $packets = array_map(function (InvoiceDto $invoice) {
            $packet = new Packet(
                PacketType::INVOICE_V01,
                $invoice
            );
            $packet->setFiscalId($this->username);

            return $packet;
        }, $invoices);

        $headers = $this->getEssentialHeaders($headers);

        $response = $this->httpClient->sendPackets($path, $packets, $headers, true, true);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     * @deprecated Use inquireByReferenceNumbers method instead which can inquire multiple reference numbers at once
     */
    public function inquiryByReferenceNumber(string $referenceNumber, array $headers = []): array
    {
        return $this->inquireByReferenceNumbers([$referenceNumber], $headers);
    }

    /**
     * @param string[] $referenceNumbers
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function inquireByReferenceNumbers(array $referenceNumbers, array $headers = []): array
    {
        $this->tokenIsRequired();

        $path = 'req/api/self-tsp/sync/' . PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER;

        $inquiryByReferenceNumberDto = new InquiryByReferenceNumberDto();
        $inquiryByReferenceNumberDto->setReferenceNumber($referenceNumbers);

        $packet = new Packet(
            PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER,
            $inquiryByReferenceNumberDto
        );
        $packet->setRetry(false);
        $packet->setFiscalId($this->username); // TODO

        $headers = $this->getEssentialHeaders($headers);

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $numericTaxId This is not the same as username, It's an 11 or 14 digit long number
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getEconomicCodeInformation(string $numericTaxId, array $headers = []): array
    {
        $this->tokenIsRequired();

        $path = 'req/api/self-tsp/sync/' . PacketType::GET_ECONOMIC_CODE_INFORMATION;

        $packet = new Packet(
            PacketType::GET_ECONOMIC_CODE_INFORMATION,
            json_encode(['economicCode' => $numericTaxId])
        );
        $packet->setRetry(false);
        $packet->setFiscalId($this->username);

        $headers = $this->getEssentialHeaders($headers);

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $alphaOrNumericTaxId Both username or 11 or 14 digit long number tax ID work here, at least for now?!
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getFiscalInfo(string $alphaOrNumericTaxId = '', array $headers = []): array
    {
        $this->tokenIsRequired();

        if ($alphaOrNumericTaxId === '') {
            $alphaOrNumericTaxId = $this->username;
        }

        $path = 'req/api/self-tsp/sync/' . PacketType::GET_FISCAL_INFORMATION;

        $packet = new Packet(PacketType::GET_FISCAL_INFORMATION, $alphaOrNumericTaxId);

        $headers = $this->getEssentialHeaders($headers);

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array<string, mixed> $headers No need to specify these if you don't need to override what's generated by default
     * @return array<string, mixed>
     * @throws GuzzleException
     */
    public function getServerInformation(array $headers = []): array
    {
        $path = 'req/api/self-tsp/sync/' . PacketType::GET_SERVER_INFORMATION;

        $headers = $this->getEssentialHeaders($headers, false);

        $packet = new Packet(PacketType::GET_SERVER_INFORMATION);

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function generateTaxId(DateTimeInterface $invoiceCreatedAt, int $internalInvoiceId): string
    {
        return $this->invoiceIdService->generateInvoiceId($invoiceCreatedAt, $internalInvoiceId);
    }

    public function normalizeInvoiceNumber(int $internalInvoiceId): string
    {
        return str_pad(dechex($internalInvoiceId), 10, 0, STR_PAD_LEFT);
    }

    private function tokenIsRequired(): void
    {
        if (!isset($this->token)) {
            throw new InvalidArgumentException('Set token before sending invoice!');
        }
    }

    /**
     * @param array<string, mixed> $providedHeaders
     * @return array<string, mixed>
     */
    private function getEssentialHeaders(array $providedHeaders = [], bool $authorizationRequired = true): array
    {
        $headers = $providedHeaders;

        if (!array_key_exists(TransferConstants::TIMESTAMP_HEADER, $headers)) {
            $headers[TransferConstants::TIMESTAMP_HEADER] = (string)(int)floor(microtime(true) * 1000);
        }

        if (!array_key_exists(TransferConstants::REQUEST_TRACE_ID_HEADER, $headers)) {
            $headers[TransferConstants::REQUEST_TRACE_ID_HEADER] = (string)Uuid::uuid4();
        }

        if ($authorizationRequired && !array_key_exists(TransferConstants::AUTHORIZATION_HEADER, $headers)) {
            $headers[TransferConstants::AUTHORIZATION_HEADER] = 'Bearer ' . $this->token->getToken();
        }

        return $headers;
    }
}
