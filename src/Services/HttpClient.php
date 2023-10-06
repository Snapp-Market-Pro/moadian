<?php

namespace SnappMarketPro\Moadian\Services;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SnappMarketPro\Moadian\Constants\TransferConstants;
use SnappMarketPro\Moadian\Dto\Packet;

class HttpClient
{
    private Client $client;

    public function __construct(
        string $baseUri,
        private SignatureService $signatureService,
        private EncryptionService $encryptionService,
    ) {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'headers' => ['Content-Type' => 'application/json'],
        ]);
    }

    /**
     * @param array<string, mixed> $headers
     * @throws GuzzleException
     */
    public function sendPacket(string $path, Packet $packet, array $headers): ResponseInterface
    {
        $cloneHeader = $headers;

        if (!empty($cloneHeader[TransferConstants::AUTHORIZATION_HEADER])) {
            $cloneHeader[TransferConstants::AUTHORIZATION_HEADER] = str_replace(
                'Bearer ',
                '',
                $cloneHeader[TransferConstants::AUTHORIZATION_HEADER]
            );
        }

        $normalizedData = Normalizer::normalizeArray(array_merge($packet->toArray(), $cloneHeader));
        $signature = $this->signatureService->sign($normalizedData);

        $content = [
            'packet' => $packet->toArray(),
            'signature' => $signature,
        ];

        return $this->post($path, json_encode($content), $headers);
    }

    /**
     * @param Packet[] $packets
     * @param array<string, string> $headers
     * @throws GuzzleException
     * @throws Exception
     */
    public function sendPackets(
        string $path,
        array $packets,
        array $headers,
        bool $encrypt = false,
        bool $sign = false
    ): ResponseInterface {
        if ($sign) {
            foreach ($packets as $packet) {
                $this->signPacket($packet);
            }
        }

        if ($encrypt) {
            $packets = $this->encryptPackets($packets);
        }

        $cloneHeader = $headers;
        $cloneHeader[TransferConstants::AUTHORIZATION_HEADER] = str_replace(
            'Bearer ',
            '',
            $cloneHeader[TransferConstants::AUTHORIZATION_HEADER]
        );

        $normalized = Normalizer::normalizeArray(
            array_merge(
                ['packets' => [array_map(fn ($p) => $p->toArray(), $packets)]],
                $cloneHeader
            )
        );

        $signature = $this->signatureService->sign($normalized);

        $content = [
            'packets' => array_map(fn ($p) => $p->toArray(), $packets),
            'signature' => $signature,
            'signatureKeyId' => null,
        ];

        return $this->post($path, json_encode($content), $headers);
    }

    private function signPacket(Packet $packet): void
    {
        $normalized = Normalizer::normalizeArray($packet->getData()->toArray());
        $signature = $this->signatureService->sign($normalized);

        $packet->setDataSignature($signature);
    }

    /**
     * @param Packet[] $packets
     * @return Packet[]
     * @throws Exception
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
            $packet->setData(
                $this->encryptionService->encrypt(
                    json_encode($packet->getData()->toArray()),
                    hex2bin($aesHex),
                    hex2bin($iv)
                )
            );
        }

        return $packets;
    }

    /**
     * @param array<string, mixed> $headers
     * @throws GuzzleException
     */
    private function post(string $path, string $content, array $headers = []): ResponseInterface
    {
        return $this->client->post($path, [
            'body' => $content,
            'headers' => $headers,
        ]);
    }
}
