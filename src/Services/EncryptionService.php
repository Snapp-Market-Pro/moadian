<?php

namespace SnappMarketPro\Moadian\Services;

use phpseclib3\Crypt\RSA;

class EncryptionService
{
    private const CIPHER = 'aes-256-gcm';
    private const TAG_LENGTH = 16;

    public function __construct(private $taxOrgPublicKey, private ?string $encryptionKeyId)
    {
    }

    /**
     * @param string $key MUST be binary, if it is hex use hex2bin
     * @param string $iv MUST be binary, if it is hex use hex2bin
     */
    public function encrypt(string $text, string $key, string $iv): string
    {
        $text = $this->xorStrings($text, $key);

        $tag = '';

        $cipherText = openssl_encrypt(
            $text,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            "",
            self::TAG_LENGTH
        );

        return base64_encode($cipherText.$tag);
    }

    public function decrypt(string $encryptedText, string $key, string $iv, int $tagLen): string
    {
        $bytes = base64_decode($encryptedText);
        $tag = substr($bytes, -$tagLen);

        $cipherText = substr($bytes, 0, -$tagLen);

        $decrypted = openssl_decrypt(
            $cipherText,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            ''
        );

        return $this->xorStrings($decrypted, $key);
    }

    public function encryptAesKey(string $aesKey): string
    {
        $rsa = RSA::loadPublicKey($this->taxOrgPublicKey);

        $encryptedKey = $rsa->encrypt($aesKey);

        return base64_encode($encryptedKey);
    }

    public function getEncryptionKeyId(): string
    {
        return $this->encryptionKeyId;
    }

    public function xorStrings(string $source, string $key): string
    {
        $sourceLength = strlen($source);
        $keyLength = strlen($key);
        $result = '';
        for ($i = 0; $i < $sourceLength; $i++) {
            $result .= $source[$i] ^ $key[$i % $keyLength];
        }
        return $result;
    }
}
