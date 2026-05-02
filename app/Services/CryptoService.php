<?php

namespace App\Services;

use App\Contracts\CryptoInterface;

class CryptoService implements CryptoInterface
{
    private string $cipher = 'AES-256-CBC';

    private string $key;

    public function __construct()
    {
        $this->key = config('app.api_crypto_key'); // store in .env
    }

    private function encryptFy(array $data): string
    {
        $iv = random_bytes(openssl_cipher_iv_length($this->cipher));

        $encrypted = openssl_encrypt(
            json_encode($data),
            $this->cipher,
            $this->key,
            0,
            $iv
        );

        // 🔐 Create HMAC (IMPORTANT LINE)
        $hmac = hash_hmac('sha256', $encrypted, $this->key);

        // Combine IV + HMAC + Encrypted data
        return base64_encode($iv.$hmac.$encrypted);
    }

    private function decryptFy(string $payload): array
    {
        $decoded = base64_decode($payload);

        $ivLength = openssl_cipher_iv_length($this->cipher);

        // Extract parts
        $iv = substr($decoded, 0, $ivLength);
        $hmac = substr($decoded, $ivLength, 64); // sha256 = 64 chars
        $encrypted = substr($decoded, $ivLength + 64);

        // 🔐 Verify HMAC BEFORE decrypt
        $calculatedHmac = hash_hmac('sha256', $encrypted, $this->key);

        if (! hash_equals($hmac, $calculatedHmac)) {
            throw new \Exception('Data tampered or invalid payload');
        }

        // Decrypt only if valid
        $decrypted = openssl_decrypt(
            $encrypted,
            $this->cipher,
            $this->key,
            0,
            $iv
        );

        return json_decode($decrypted, true) ?? [];
    }

    public function encrypt(array $data): string
    {
        return $this->encryptFy($data);
    }

    public function decrypt(string $payload): array
    {
        return $this->decryptFy($payload);
    }

}
