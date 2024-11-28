<?php

namespace QuetzalStudio\PhpSnapBi\Services;

use QuetzalStudio\PhpSnapBi\Client\Client;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;
use QuetzalStudio\PhpSnapBi\Provider;

class Service
{
    protected Client $client;

    protected ?string $accessToken = null;

    public function __construct(
        protected Provider $provider,
        protected string|int $channelId,
        protected string|int $externalId,
        protected ?ServicePayload $payload = null,
        protected string|int|null $timestamp = null,
    ) {
        $this->client = new Client($provider);

        $this->accessToken = Config::serviceSignatureIsSymmetric()
            ? $provider->getAccessToken()
            : null;

        $this->timestamp = $timestamp ?? time();
    }
}
