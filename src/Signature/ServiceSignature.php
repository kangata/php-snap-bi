<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Signature;

class ServiceSignature
{
    public static function symmetric(string $clientSecret, ServiceSignaturePayload $data): string
    {
        return base64_encode(hash_hmac('sha512', (string) $data, $clientSecret, true));
    }

    public static function symmetricVerify(
        ServiceSignaturePayload $data,
        string $signature,
        string $clientSecret
    ): bool {
        return hash_equals($signature, static::symmetric($clientSecret, $data));
    }
}
