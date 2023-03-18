<?php

namespace Src\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Src\Constants\TransferConstants;
use Src\Dto\Packet;
use Psr\Http\Message\ResponseInterface;
use Ulid\Ulid;

class HttpClient
{
    private Client $client;

    public function __construct(
        string $baseUri,
        private SignatureService $signatureService,
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
        $normalizedData = Normalizer::normalizeArray(array_merge($packet->toArray(), $headers));
        $signature = $this->signatureService->sign($normalizedData);

        $content = [
            'packet' => $packet->toArray(),
            'signature' => $signature,
        ];

        if (isset($headers[TransferConstants::AUTHORIZATION_HEADER])) {
            $headers[TransferConstants::AUTHORIZATION_HEADER] = 'Bearer ' . $headers[TransferConstants::AUTHORIZATION_HEADER];
//            dd($content, $headers);
        }

        $response = $this->post($path, json_encode($content), $headers);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param Packet[] $packets
     * @param array<string, string> $headers
     */
    public function sendPackets(string $path, array $packets, array $headers, bool $encrypt = false, bool $sign = false)
    {
        dd(333);
        $headers = $this->fillEssentialHeaders($headers);
        if ($sign) {
            foreach ($packets as $packet) {
                $this->signPacket($packet);
            }
        }

        if ($encrypt) {
            $packets = $this->encryptPackets($packets);
        }

        $normalized = Normalizer::normalizeArray([
                ...array_map(fn($a) => $a->toArray(), $packets),
                ...$headers
            ]
        );

        $signature = $this->signatureService->sign($normalized);

        if (isset($headers[TransferConstants::AUTHORIZATION_HEADER])) {
            $headers[TransferConstants::AUTHORIZATION_HEADER] = 'Bearer ' . $headers[TransferConstants::AUTHORIZATION_HEADER];
        }
        $content = [
            'packets' => array_map(fn($p) => $p->toArray(), $packets),
            'signature' => $signature,
        ];

        if ($this->signatureService->getKeyId() !== null) {
            $content['signatureKeyId'] = $this->signatureService->getKeyId();
        }
        return $this->post($path, json_encode($content), $headers);
    }

    private function signPacket(Packet $packet): void
    {
        $normalized = Normalizer::normalizeArray($packet->getData()->toArray());
        $signature = $this->signatureService->sign($normalized);

        $packet->setDataSignature($signature);
        $packet->setSignatureKeyId($this->signatureService->getKeyId());
    }

    /**
     * @param Packet[] $packets
     * @return Packet[]
     */
    private function encryptPackets(array $packets): array
    {
        $aesKey = bin2hex(random_bytes(32));
        $encryptedAesKey = $this->encryptionService->encryptAesKey($aesKey);
        $iv = bin2hex(random_bytes(16));

        foreach ($packets as $packet) {
            $packet->setIv($iv);
            $packet->setSymmetricKey($encryptedAesKey);
            $packet->setEncryptionKeyId($this->encryptionService->getEncryptionKeyId());
            $packet->setData($this->encryptionService->encrypt(json_encode($packet->getData()->toArray()), $aesKey, $iv, 16));
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