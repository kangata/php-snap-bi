<?php

use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\PrivateKey;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\ProviderConfig;
use QuetzalStudio\PhpSnapBi\Services\Auth\B2BAccessToken\GetAccessToken;

test('get acess token b2b', function () {
    $privateKey = null;

    openssl_pkey_export(openssl_pkey_new(), $privateKey);

    Config::load(
        privateKey: new PrivateKey($privateKey),
        origin: 'quetzalstudio.local',
    );

    $provider = new Provider('bca', new ProviderConfig(
        clientId: '19e598e5-aae3-4693-9da6-87ad9d457bf0',
        clientSecret: 'KKrjoiLvN9sbZo7TIUJz1DsANBMlopIpEaS9bmyswM8ULeS1nQW4vQhq3cjKhhgq',
        baseUrl: 'http://localhost:8101/701653eb-9461-44ad-ac97-75b380a636fb',
        apiPrefix: '/openapi',
    ));

    $accessToken = new GetAccessToken($provider);

    $response = $accessToken->send();

    expect($response->getStatusCode() == 200)->toBeTrue();
    expect($json = (string) $response->getBody())->toBeJson();
    expect($data = json_decode($json, true))->toHaveKeys([
        'responseCode',
        'responseMessage',
        'accessToken',
        'tokenType',
        'expiresIn',
    ]);
    expect($data['responseCode'])->toBeString()->toBe('2007300');
});
