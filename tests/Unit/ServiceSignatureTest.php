<?php

use QuetzalStudio\PhpSnapBi\Signature\ServiceSignature;
use QuetzalStudio\PhpSnapBi\Signature\ServiceSignaturePayload;
use QuetzalStudio\PhpSnapBi\Timestamp;

test('create service signature', function () {
    $clientSecret = 'KKrjoiLvN9sbZo7TIUJz1DsANBMlopIpEaS9bmyswM8ULeS1nQW4vQhq3cjKhhgq';

    $data = [
        'RequestID' => '15a432fb-cc08-4931-a727-3f606641ac97',
        'AccountNumber' => '123456789',
        'StartDate' => '2024-02-29',
        'EndDate' => '2024-02-29',
    ];

    $signature = ServiceSignature::symmetric($clientSecret, new ServiceSignaturePayload(
        httpMethod: 'POST',
        endpointUrl: '/openapi/v1.0/transfer-va/inquiry-intrabank',
        accessToken: 'aGk1TFlEeXZ2dkZVcG1tajV4TG1hMzlGTlVFTXB6Wm0=',
        timestamp: new Timestamp(time()),
        payload: json_encode($data),
    ));

    expect($signature)->toBeString();
});
