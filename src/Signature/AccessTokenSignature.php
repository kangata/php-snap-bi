<?php

namespace QuetzalStudio\PhpSnapBi\Signature;

use QuetzalStudio\PhpSnapBi\Exceptions\SignatureException;
use QuetzalStudio\PhpSnapBi\PrivateKey;

class AccessTokenSignature
{
    public static function asymmetric(PrivateKey $privateKey, AccessTokenSignaturePayload $data): string
    {
        $signature = null;

        openssl_sign((string) $data, $signature, $privateKey->value(), 'RSA-SHA256');

        if (! $signature) {
            throw new SignatureException;
        }

        return base64_encode($signature);
    }

    public static function asymmetricVerify(
        AccessTokenSignaturePayload $data,
        string $signature,
        string $publicKey
    ): int {
        $asymmetricKey = openssl_pkey_get_public($publicKey);

        return openssl_verify((string) $data, base64_decode($signature), $asymmetricKey, 'RSA-SHA256');
    }
}
