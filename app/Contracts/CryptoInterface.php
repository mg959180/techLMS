<?php

namespace App\Contracts;

interface CryptoInterface
{
    public function encrypt(array $data): string;
    public function decrypt(string $payload): array;
}
