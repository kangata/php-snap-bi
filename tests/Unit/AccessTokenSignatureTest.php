<?php

use QuetzalStudio\PhpSnapBi\PrivateKey;
use QuetzalStudio\PhpSnapBi\Signature\AccessTokenSignature;
use QuetzalStudio\PhpSnapBi\Signature\AccessTokenSignaturePayload;
use QuetzalStudio\PhpSnapBi\Timestamp;

test('created access token signature', function () {
    $privateKey = null;

    openssl_pkey_export(openssl_pkey_new(), $privateKey);

    $privateKey = new PrivateKey($privateKey);
    $clientId = '12989e36-cca0-451c-959b-a1de2c4df02f';

    $signature = AccessTokenSignature::asymmetric($privateKey, new AccessTokenSignaturePayload(
        clientId: $clientId,
        timestamp: new Timestamp(time()),
    ));

    expect($signature)->toBeString();
});
