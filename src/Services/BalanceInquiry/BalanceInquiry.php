<?php

namespace QuetzalStudio\PhpSnapBi\Services\BalanceInquiry;

use QuetzalStudio\PhpSnapBi\Client\Client;
use QuetzalStudio\PhpSnapBi\Concerns\HasService;
use QuetzalStudio\PhpSnapBi\Contracts\Service;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;
use QuetzalStudio\PhpSnapBi\Provider;

class BalanceInquiry implements Service
{
    use HasService;

    protected Client $client;

    protected string $version = 'v1.0';

    protected string $endpoint = '/:version/balance-inquiry';

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
