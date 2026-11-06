<?php

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment\Payload;

test('direct debit payment payload sends urls as urlParams', function () {
    $urls = [
        [
            'url' => 'https://merchant.example/return',
            'type' => 'PAY_RETURN',
            'isDeeplink' => 'N',
        ],
    ];

    $data = (new Payload(
        partnerReferenceNumber: 'REF-001',
        merchantId: 'MERCHANT-001',
        amount: new Amount(10000),
        urls: $urls,
    ))->toArray();

    expect($data)->toHaveKey('urlParams')
        ->and($data['urlParams'])->toBe($urls)
        ->and($data)->not->toHaveKey('urlParam');
});
