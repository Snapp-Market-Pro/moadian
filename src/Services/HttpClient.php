<?php

namespace SnappMarketPro\Moadian\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SnappMarketPro\Moadian\Constants\TransferConstants;
use SnappMarketPro\Moadian\Dto\Packet;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    private Client $client;

    public function __construct(
        string                    $baseUri,
        private SignatureService  $signatureService,
        private EncryptionService $encryptionService,
    )
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'headers' => ['Content-Type' => 'application/json'],
        ]);
    }

    public function sendPacket(string $path, Packet $packet, array $headers)
    {
        $cloneHeader = $headers;

        if (!empty($cloneHeader['Authorization'])) {
            $cloneHeader['Authorization'] = str_replace('Bearer ', '', $cloneHeader['Authorization']);
        }

        $normalizedData = Normalizer::normalizeArray(array_merge($packet->toArray(), $cloneHeader));
        $signature = $this->signatureService->sign($normalizedData);

        $content = [
            'packet' => $packet->toArray(),
            'signature' => $signature,
        ];
        $response = $this->post($path, json_encode($content), $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param Packet[] $packets
     * @param array<string, string> $headers
     */
    public function sendPackets(string $path, array $packets, array $headers, bool $encrypt = false, bool $sign = false)
    {
        $headers = $this->fillEssentialHeaders($headers);

        // TODO: Wrong value for indati2m and indati2m, taxId

        if ($sign) {
            foreach ($packets as $packet) {
                $this->signPacket($packet);
            }
        }

        if ($encrypt) {
            $packets = $this->encryptPackets($packets);
        }

        $cloneHeader = $headers;
        $cloneHeader['Authorization'] = str_replace('Bearer ', '', $cloneHeader['Authorization']);

        $normalized = Normalizer::normalizeArray(
            array_merge(
                ['packets' => [$packets[0]->toArray()]],
                $cloneHeader
            )
        );

        $signature = $this->signatureService->sign($normalized);

        /*if (isset($headers[TransferConstants::AUTHORIZATION_HEADER])) {
            $headers[TransferConstants::AUTHORIZATION_HEADER] = 'Bearer ' . $headers[TransferConstants::AUTHORIZATION_HEADER];
        }*/

        $content = [
            'packets' => array_map(fn($p) => $p->toArray(), $packets),
            'signature' => $signature,
            'signatureKeyId' => null,
        ];


        return $this->post($path, json_encode($content), [...$headers, 'Content-Type' => 'application/json']);
    }

    private function signPacket(Packet $packet): void
    {
        $normalized = Normalizer::normalizeArray($packet->getData()->toArray());
        $signature = $this->signatureService->sign($normalized);

        $packet->setDataSignature($signature);
        // TODO: Not sure?
//        $packet->setSignatureKeyId($this->signatureService->getKeyId());
    }

    /**
     * @param Packet[] $packets
     * @return Packet[]
     */
    private function encryptPackets(array $packets): array
    {
        $aesHex = bin2hex(random_bytes(32));
        $iv = bin2hex(random_bytes(16));
        $encryptedAesKey = $this->encryptionService->encryptAesKey($aesHex);

        foreach ($packets as $packet) {
            $packet->setIv($iv);
            $packet->setSymmetricKey($encryptedAesKey);
            $packet->setEncryptionKeyId($this->encryptionService->getEncryptionKeyId());
            $packet->setData($this->encryptionService->encrypt(json_encode($packet->getData()->toArray()), hex2bin($aesHex), hex2bin($iv)));
        }

        return $packets;
    }

    /**
     * @throws GuzzleException
     */
    private function post(string $path, string $content, array $headers = []): ResponseInterface
    {
        return $this->client->post($path, [
            'body' => $content,
            'headers' => $headers,
        ]);
    }

    /**
     * @param array<string, string> $headers
     * @return array<string, string>
     */
    private function fillEssentialHeaders(array $headers): array
    {
        if (!isset($headers[TransferConstants::TIMESTAMP_HEADER])) {
            $headers[TransferConstants::TIMESTAMP_HEADER] = '1678654079000';
        }

        if (!isset($headers[TransferConstants::REQUEST_TRACE_ID_HEADER])) {
            $headers[TransferConstants::REQUEST_TRACE_ID_HEADER] = 'AAA';
        }

        return $headers;
    }
}
