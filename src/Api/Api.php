<?php

namespace Src\Api;

use GuzzleHttp\Exception\GuzzleException;
use Src\Constants\PacketType;
use Src\Constants\TransferConstants;
use Src\Dto\GetTokenDto;
use Src\Dto\InvoiceDto;
use Src\Dto\Packet;
use Src\Dto\Token;
use Src\Services\HttpClient;
use Src\Services\Normalizer;
use Src\Services\SignatureService;
use Ramsey\Uuid\Uuid;
use Ulid\Ulid;

class Api
{
    private ?Token $token = null;

    public function __construct(
        private string $username,
        private HttpClient $httpClient,
    )
    {
    }

    /**
     * @throws GuzzleException
     */
    public function getToken(): Token
    {
        $packet = new Packet(PacketType::GET_TOKEN, new GetTokenDto($this->username));

        $packet->setFiscalId($this->username);

        $headers = $this->getEssentialHeaders();

        $response = $this->httpClient->sendPacket('req/api/self-tsp/sync/GET_TOKEN', $packet, $headers);

        return new Token($response['result']['data']['token'], $response['result']['data']['expiresIn']);
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

        $headers[TransferConstants::AUTHORIZATION_HEADER] = $this->token->getToken();

        return $this->httpClient->sendPacket('req/api/self-tsp/sync/GET_FISCAL_INFORMATION', $packet, $headers);
    }

    public function setToken(Token $token): self
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
