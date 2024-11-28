```php
<?php

use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\AccountInquiry;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\Payload;
use QuetzalStudio\RequestLogger\RequestLogger;

Config::serviceSignatureUseAsymmetric();

$provider = Provider::load('dana', [
    'client' => Http::withUserAgent('SNAP-CLIENT/1.0'),
]);

$request = new AccountInquiry(
    provider: $provider,
    channelId: $provider->config()->channelId(),
    externalId: time(),
);

$response = $request->send(new Payload(
    partnerReferenceNo: time(),
    beneficiaryAccountNumber: '01234567890',
    amount: new Amount(10000),
    additionalInfo: new AdditionalInfo(
        fundType: 'MERCHANT_WITHDRAW_FOR_CORPORATE',
        beneficiaryBankCode: '014',
    ),
));

(new RequestLogger)
    ->channel($provider->config()->logChannel())
    ->request($response->transferStats->getRequest())
    ->response($response)
    ->create();

dd($response->status(), $response->json());
```
