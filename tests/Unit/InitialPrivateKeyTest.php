<?php

use QuetzalStudio\PhpSnapBi\Exceptions\PrivateKeyException;
use QuetzalStudio\PhpSnapBi\PrivateKey;

test('initial valid private key', function () {
    $privateKey = null;

    openssl_pkey_export(openssl_pkey_new(), $privateKey);

    $privateKey = new PrivateKey($privateKey);

    expect($privateKey->value() instanceof OpenSSLAsymmetricKey)->toBeTrue();
});

test('initial valid private key from path', function () {
    $privateKeyPath = sys_get_temp_dir().'/private.key';

    openssl_pkey_export_to_file(openssl_pkey_new(), $privateKeyPath);

    $privateKey = new PrivateKey(path: $privateKeyPath);

    expect($privateKey->value() instanceof OpenSSLAsymmetricKey)->toBeTrue();
});

test('initial invalid private key', function () {
    $privateKey = '';

    try {
        $privateKey = new PrivateKey($privateKey);
    } catch (Throwable $e) {
        expect($e instanceof PrivateKeyException)->toBeTrue();
    }
});
