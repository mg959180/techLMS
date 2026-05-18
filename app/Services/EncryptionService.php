<?php

namespace App\Services;

use RuntimeException;

class EncryptionService
{
    private const CIPHER_BITS = 4096;
    private const PRIVATE_KEY_PATH = 'app/private/login_rsa_private.pem';

    public function publicKey(): string
    {
        $privateKey = $this->privateKey();
        $keyDetails = openssl_pkey_get_details($privateKey);

        if (! is_array($keyDetails) || empty($keyDetails['key'])) {
            throw new RuntimeException('Unable to read login encryption public key.');
        }

        return $keyDetails['key'];
    }

    public function decryptPayload(string $payload): array
    {
        $encrypted = base64_decode($payload, true);

        if ($encrypted === false) {
            throw new RuntimeException('Invalid encrypted login payload.');
        }

        $isDecrypted = openssl_private_decrypt(
            $encrypted,
            $decrypted,
            $this->privateKey(),
            OPENSSL_PKCS1_OAEP_PADDING
        );

        if (! $isDecrypted) {
            throw new RuntimeException('Unable to decrypt login payload.');
        }

        $data = json_decode($decrypted, true);

        if (! is_array($data)) {
            throw new RuntimeException('Invalid login payload data.');
        }

        return $data;
    }

    private function privateKey(): mixed
    {
        $path = storage_path(self::PRIVATE_KEY_PATH);

        if (! file_exists($path)) {
            $this->generateKeyPair($path);
        }

        $key = openssl_pkey_get_private(file_get_contents($path));

        if ($key === false) {
            throw new RuntimeException('Unable to read login encryption private key.');
        }

        return $key;
    }

    private function generateKeyPair(string $path): void
    {
        $directory = dirname($path);

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create login key directory.');
        }

        $opensslConfig = $this->opensslConfig();

        $privateKey = openssl_pkey_new([
            ...$opensslConfig,
            'private_key_bits' => self::CIPHER_BITS,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ]);

        if ($privateKey === false || ! openssl_pkey_export($privateKey, $privateKeyPem, null, $opensslConfig)) {
            throw new RuntimeException('Unable to generate login encryption key.');
        }

        file_put_contents($path, $privateKeyPem, LOCK_EX);
    }

    private function opensslConfig(): array
    {
        $configuredPath = getenv('OPENSSL_CONF');

        if ($configuredPath && file_exists($configuredPath)) {
            return ['config' => $configuredPath];
        }

        $candidates = [
            'C:\\php\\extras\\ssl\\openssl.cnf',
            PHP_BINARY ? dirname(PHP_BINARY).DIRECTORY_SEPARATOR.'extras'.DIRECTORY_SEPARATOR.'ssl'.DIRECTORY_SEPARATOR.'openssl.cnf' : null,
        ];

        foreach ($candidates as $candidate) {
            if ($candidate && file_exists($candidate)) {
                return ['config' => $candidate];
            }
        }

        return [];
    }
}
