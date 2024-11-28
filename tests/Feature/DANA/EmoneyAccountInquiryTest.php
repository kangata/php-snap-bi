<?php

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\PrivateKey;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\ProviderConfig;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\AccountInquiry;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry\Payload;
use QuetzalStudio\PhpSnapBi\Services\DANA\Enums\FundType;

test('dana emoney bank account inquiry', function () {
    $privateKey = null;

    openssl_pkey_export(openssl_pkey_new(), $privateKey);

    Config::load(
        privateKey: new PrivateKey($privateKey),
        origin: 'quetzalstudio.local',
    );

    Config::serviceSignatureUseAsymmetric();

    $provider = new Provider('dana', new ProviderConfig(
        clientId: '19e598e5-aae3-4693-9da6-87ad9d457bf0',
        clientSecret: 'KKrjoiLvN9sbZo7TIUJz1DsANBMlopIpEaS9bmyswM8ULeS1nQW4vQhq3cjKhhgq',
        baseUrl: 'http://localhost:8101/f48be58e-adc5-45cb-ab1e-d4624780e9e6',
        apiPrefix: '',
    ));

    $transfer = new AccountInquiry(
        provider: $provider,
        channelId: '95221',
        externalId: time(),
    );

    $response = $transfer->send(new Payload(
        partnerReferenceNo: time(),
        beneficiaryAccountNumber: '01234567890',
        amount: new Amount(10000),
        additionalInfo: new AdditionalInfo(
            fundType: PHP_VERSION >= '8.1'
                ? FundType::MERCHANT_WITHDRAW_FOR_CORPORATE
                : 'MERCHANT_WITHDRAW_FOR_CORPORATE',
            beneficiaryBankCode: '014',
        ),
    ));

    expect($response->getStatusCode() == 200)->toBeTrue();
    expect($json = (string) $response->getBody())->toBeJson();
    expect($data = json_decode($json, true))->toHaveKeys([
        'responseCode',
        'responseMessage',
        'beneficiaryAccountNumber',
        'beneficiaryAccountName',
        'beneficiaryBankCode',
        'beneficiaryBankShortName',
        'beneficiaryBankName',
        'amount.value',
        'amount.currency',
        'additionalInfo',
        'additionalInfo.feeAmount',
        'additionalInfo.feeAmount.value',
        'additionalInfo.feeAmount.currency',
        'additionalInfo.maxAmount',
        'additionalInfo.maxAmount.value',
        'additionalInfo.maxAmount.currency',
    ]);
    expect($data['responseCode'])->toBeString()->toBe('2004200');
});
