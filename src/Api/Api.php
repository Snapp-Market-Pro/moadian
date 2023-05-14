<?php

namespace AlirezaA2F\Moadian\Api;

use Ramsey\Uuid\Uuid;
use AlirezaA2F\Moadian\Constants\PacketType;
use AlirezaA2F\Moadian\Constants\TransferConstants;
use AlirezaA2F\Moadian\Dto\GetTokenDto;
use AlirezaA2F\Moadian\Dto\InquiryByReferenceNumberDto;
use AlirezaA2F\Moadian\Dto\Packet;
use AlirezaA2F\Moadian\Dto\Token;
use AlirezaA2F\Moadian\Services\HttpClient;

class Api
{
    private ?Token $token = null;

    public function __construct(
        private readonly string     $username,
        private readonly HttpClient $httpClient,
    )
    {
    }

    public function getToken(): Token
    {
        $path = 'req/api/self-tsp/sync/GET_TOKEN';

        $packet = new Packet(PacketType::GET_TOKEN, new GetTokenDto($this->username));

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);

        $headers = $this->getEssentialHeaders();

        $response = $this->httpClient->sendPacket($path, $packet, $headers);

        return new Token($response['result']['data']['token'], $response['result']['data']['expiresIn']);
    }


    public function inquiryByReferenceNumber(string $referenceNumber)
    {
        $path = 'req/api/self-tsp/sync/' . PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER;

        $inquiryByReferenceNumberDto = new InquiryByReferenceNumberDto();
        $inquiryByReferenceNumberDto->setReferenceNumber($referenceNumber);

        $packet = new Packet(
            PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER,
            $inquiryByReferenceNumberDto
        );

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);
        $headers = $this->getEssentialHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        return $this->httpClient->sendPacket($path, $packet, $headers);
    }

    public function getEconomicCodeInformation(string $taxID)
    {
        $path = 'req/api/self-tsp/sync/' . PacketType::GET_ECONOMIC_CODE_INFORMATION;

        $this->requireToken();

        $packet = new Packet(
            PacketType::GET_ECONOMIC_CODE_INFORMATION,
            json_encode(["economicCode" => $taxID])
        );

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);
        $headers = $this->getEssentialHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        return $this->httpClient->sendPacket($path, $packet, $headers);
    }

    public function sendInvoices(array $invoiceDtos): string
    {
        $path = 'req/api/self-tsp/async/normal-enqueue';

        $packets = [];

        foreach ($invoiceDtos as $invoiceDto) {
            $packet = new Packet(
                PacketType::INVOICE_V01,
                $invoiceDto
            );
            $packet->setUid('AAA');
            $packets[] = $packet;
        }

        $headers = $this->getEssentialHeaders();

        $headers[TransferConstants::AUTHORIZATION_HEADER] = $this->token->getToken();

        try {
            $res = $this->httpClient->sendPackets(
                $path,
                $packets,
                $headers,
                true,
                true,
            );
        } catch (\Exception $e) {
        }

        return $res->getBody()->getContents();
    }

    /**
     * @return array
     */
    public function getFiscalInfo(): array
    {
        $path = 'req/api/self-tsp/sync/GET_FISCAL_INFORMATION';

        $this->requireToken();

        $packet = new Packet(
            PacketType::GET_FISCAL_INFORMATION,
            $this->username
        );

        $headers = $this->getEssentialHeaders();

        // $headers[TransferConstants::AUTHORIZATION_HEADER] = $this->token->getToken();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        return $this->httpClient->sendPacket($path, $packet, $headers);
    }

    private function getServerInformation(): array
    {
        $path = 'req/api/self-tsp/sync/GET_SERVER_INFORMATION';

        $packet = new Packet(
            PacketType::GET_SERVER_INFORMATION,
            json_encode([
                'time' => 1,
                'packet' => [
                    'uid' => null,
                    'packetType' => PacketType::GET_SERVER_INFORMATION,
                    'retry' => false,
                    'data' => null,
                    'encryptionKeyId' => '',
                    'symmetricKey' => '',
                    'iv' => '',
                    'fiscalId' => '',
                    'dataSignature' => '',
                ],
            ]),
        );

        $now = floor(microtime(true) * 1000);

        $headers = [
            'timestamp' => $now,
            'uid' => $now,
            'content-type' => 'application/json',
        ];

        return $this->httpClient->sendPacket($path, $packet, $headers);
    }

    public function setToken(null|Token $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return array<string>
     */
    private function getEssentialHeaders(): array
    {
        return [
            TransferConstants::TIMESTAMP_HEADER => (string)(int)floor(microtime(true) * 1000),
            TransferConstants::REQUEST_TRACE_ID_HEADER => (string)Uuid::uuid4(),
        ];
    }

    private function requireToken(): void
    {
        if ($this->token === null || $this->token->isExpired()) {
            $this->token = $this->getToken();
        }
    }
}
