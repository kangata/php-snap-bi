<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment;

use QuetzalStudio\PhpSnapBi\Client\Client;
use QuetzalStudio\PhpSnapBi\Concerns\HasService;
use QuetzalStudio\PhpSnapBi\Contracts\Service;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;
use QuetzalStudio\PhpSnapBi\Provider;

class DirectDebitPayment implements Service
{
    use HasService;

    protected Client $client;

    protected string $version = 'v1.0';

    protected string $endpoint = '/api/:version/debit/payment-host-to-host';

    protected ?string $accessToken = null;

    public function __construct(
        protected Provider $provider,
        protected string|int $channelId,
        protected string|int $externalId,
        protected ?ServicePayload $payload = null,
        protected string|int|null $timestamp = null,
    ) {
        $this->client = new Client($provider);
        $this->accessToken = $provider->getAccessToken();
        $this->timestamp = $timestamp ?? time();
    }
}
