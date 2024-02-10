<?php

use QuetzalStudio\PhpSnapBi\Exceptions\PublicKeyException;
use QuetzalStudio\PhpSnapBi\PublicKey;

test('initial valid public key', function () {
    $privateKey = openssl_pkey_new();
    $publicKey = new PublicKey(openssl_pkey_get_details($privateKey)['key']);

    expect($publicKey->value() instanceof OpenSSLAsymmetricKey)->toBeTrue();
});

test('initial valid public key from path', function () {
    $privateKey = openssl_pkey_new();
    $publicKeyPath = sys_get_temp_dir().'/public.key';

    file_put_contents($publicKeyPath, openssl_pkey_get_details($privateKey)['key']);

    $publicKey = new PublicKey(path: $publicKeyPath);

    expect($publicKey->value() instanceof OpenSSLAsymmetricKey)->toBeTrue();
});

test('initial invalid private key', function () {
    $privateKeyContent = '';

    try {
        new PublicKey($privateKeyContent);
    } catch (Throwable $e) {
        expect($e instanceof PublicKeyException)->toBeTrue();
    }
});
