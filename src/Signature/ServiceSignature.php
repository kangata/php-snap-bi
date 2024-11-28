<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Signature;

use QuetzalStudio\PhpSnapBi\Exceptions\SignatureException;
use QuetzalStudio\PhpSnapBi\PrivateKey;

class ServiceSignature
{
    public static function asymmetric(PrivateKey $privateKey, ServiceSignaturePayload $data): string
    {
        $signature = null;

        openssl_sign((string) $data, $signature, $privateKey->value(), 'RSA-SHA256');

        if (! $signature) {
            throw new SignatureException;
        }

        return base64_encode($signature);
    }

    public static function asymmetricVerify(
        ServiceSignaturePayload $data,
        string $signature,
        string $publicKey
    ): int {
        $asymmetricKey = openssl_pkey_get_public($publicKey);

        return openssl_verify((string) $data, base64_decode($signature), $asymmetricKey, 'RSA-SHA256');
    }

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
