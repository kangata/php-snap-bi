```php
<?php

use App\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyTransferBank\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyTransferBank\Payload;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyTransferBank\Transfer;
use QuetzalStudio\RequestLogger\RequestLogger;

Config::serviceSignatureUseAsymmetric();

$provider = Provider::load('dana', [
    'client' => Http::withUserAgent('SNAP-CLIENT/1.0'),
]);

$request = new Transfer(
    provider: $provider,
    channelId: $provider->config()->channelId(),
    externalId: time(),
);

$response = $request->send(new Payload(
    partnerReferenceNo: time(),
    beneficiaryAccountNumber: '01234567890',
    beneficiaryBankCode: '014',
    amount: new Amount(10000),
    additionalInfo: new AdditionalInfo(
        fundType: 'MERCHANT_WITHDRAW_FOR_CORPORATE',
    ),
));

(new RequestLogger)
    ->channel($provider->config()->logChannel())
    ->request($response->transferStats->getRequest())
    ->response($response)
    ->create();

dd($response->status(), $response->json());
```
