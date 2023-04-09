<?php

namespace Arissystem\Moadian\Api;

use Ramsey\Uuid\Uuid;
use Arissystem\Moadian\Constants\PacketType;
use Arissystem\Moadian\Constants\TransferConstants;
use Arissystem\Moadian\Dto\GetTokenDto;
use Arissystem\Moadian\Dto\InquiryByReferenceNumberDto;
use Arissystem\Moadian\Dto\Packet;
use Arissystem\Moadian\Dto\Token;
use Arissystem\Moadian\Services\HttpClient;

class Api
{
    private string $username;
    private HttpClient $httpClient;
    private ?Token $token = null;

    public function __construct(string $username, HttpClient $httpClient)
    {
        $this->username = $username;
        $this->httpClient = $httpClient;
    }

    /**
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
     * @return array
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

    public function setToken(?Token $token): self
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
