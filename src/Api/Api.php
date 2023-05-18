<?php

namespace SnappMarketPro\Moadian\Api;

use GuzzleHttp\Exception\GuzzleException;
use Ramsey\Uuid\Uuid;
use SnappMarketPro\Moadian\Constants\PacketType;
use SnappMarketPro\Moadian\Constants\TransferConstants;
use SnappMarketPro\Moadian\Dto\GetTokenDto;
use SnappMarketPro\Moadian\Dto\InquiryByReferenceNumberDto;
use SnappMarketPro\Moadian\Dto\InquiryByUidDto;
use SnappMarketPro\Moadian\Dto\Packet;
use SnappMarketPro\Moadian\Dto\Token;
use SnappMarketPro\Moadian\Services\HttpClient;

class Api
{
    private ?Token $token = null;

    public function __construct(
        private string $username,
        private HttpClient $httpClient,
    ) {
    }

    /**
     * @throws GuzzleException
     */
    public function getToken(): Token
    {
        $packet = new Packet(PacketType::GET_TOKEN, new GetTokenDto($this->username));

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);

        $headers = $this->getEssentialHeaders();

        $response = $this->httpClient->sendPacket('req/api/self-tsp/sync/GET_TOKEN', $packet, $headers);

        return new Token($response['result']['data']['token'], $response['result']['data']['expiresIn']);
    }


    public function inquiryByReferenceNumber(string $referenceNumber)
    {
        $inquiryByReferenceNumberDto = new InquiryByReferenceNumberDto();
        $inquiryByReferenceNumberDto->setReferenceNumber($referenceNumber);

        $packet = new Packet(PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER, $inquiryByReferenceNumberDto);

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);
        $headers = $this->getEssentialHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        $path = 'req/api/self-tsp/sync/' . PacketType::PACKET_TYPE_INQUIRY_BY_REFERENCE_NUMBER;

        return $this->httpClient->sendPacket($path, $packet, $headers);

    }

    public function inquiryByUid(string $uid)
    {
        $path = 'req/api/self-tsp/sync/' . PacketType::PACKET_TYPE_INQUIRY_BY_UID;

        $inquiryByUidDto = new InquiryByUidDto();
        $inquiryByUidDto->setUid($uid);

        $packet = new Packet(
            PacketType::PACKET_TYPE_INQUIRY_BY_UID,
            $uid
        );

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);
        $headers = $this->getEssentialHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        return $this->httpClient->sendPacket($path, $packet, $headers);
    }
    
    public function getEconomicCodeInformation(string $taxID)
    {
        $this->requireToken();

        $packet = new Packet(PacketType::GET_ECONOMIC_CODE_INFORMATION, json_encode(["economicCode" => $taxID]));

        $packet->setRetry(false);
        $packet->setFiscalId($this->username);
        $headers = $this->getEssentialHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        $path = 'req/api/self-tsp/sync/' . PacketType::GET_ECONOMIC_CODE_INFORMATION;

        return $this->httpClient->sendPacket($path, $packet, $headers);

    }

    public function sendInvoices(array $invoiceDtos)
    {
        $packets = [];

        foreach ($invoiceDtos as $invoiceDto) {
            $packet = new Packet(PacketType::INVOICE_V01, $invoiceDto);
            $packet->setUid('AAA');
            $packets[] = $packet;
        }

        $headers = $this->getEssentialHeaders();

        $headers[TransferConstants::AUTHORIZATION_HEADER] = $this->token->getToken();

        try {
            $res = $this->httpClient->sendPackets(
                'req/api/self-tsp/async/normal-enqueue',
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
     * @return array<mixed>
     * @throws GuzzleException
     */
    public function getFiscalInfo(): array
    {
        $this->requireToken();

        $packet = new Packet(PacketType::GET_FISCAL_INFORMATION, $this->username);

        $headers = $this->getEssentialHeaders();

        // $headers[TransferConstants::AUTHORIZATION_HEADER] = $this->token->getToken();
        $headers['Authorization'] = 'Bearer ' . $this->token->getToken();

        return $this->httpClient->sendPacket('req/api/self-tsp/sync/GET_FISCAL_INFORMATION', $packet, $headers);
    }

    public function setToken(null|Token $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return array<string, string>
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
