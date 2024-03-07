<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\Auth\B2BAccessToken;

use QuetzalStudio\PhpSnapBi\Client\Client;
use QuetzalStudio\PhpSnapBi\Client\HeaderFactory;
use QuetzalStudio\PhpSnapBi\Concerns\HasService;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Contracts\Service;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;
use QuetzalStudio\PhpSnapBi\Provider;
use QuetzalStudio\PhpSnapBi\Signature\AccessTokenSignature;
use QuetzalStudio\PhpSnapBi\Signature\AccessTokenSignaturePayload;
use QuetzalStudio\PhpSnapBi\Timestamp;

class GetAccessToken implements Service
{
    use HasService;

    protected Client $client;

    protected string $endpoint = '/:version/access-token/b2b';

    public function __construct(
        protected Provider $provider,
        protected ?Config $config = null,
        protected ?ServicePayload $payload = null,
        protected string|int|null $timestamp = null,
        protected bool $cache = false,
    ) {
        $this->config ??= Config::instance();
        $this->client = new Client($provider);
        $this->timestamp ??= time();
    }

    public function send(?ServicePayload $payload = null)
    {
        $this->payload = $payload ?? new Payload;

        return $this->client
            ->withHeaders($this->headers())
            ->post($this->provider->serviceUrl($this->endpoint()), $this->payload());
    }

    public function signature(): string
    {
        return AccessTokenSignature::asymmetric(
            $this->provider->privateKey() ?? $this->config->privateKey(),
            new AccessTokenSignaturePayload(
                $this->provider->clientId(),
                $this->timestamp
            ),
        );
    }

    public function headers(): array
    {
        return HeaderFactory::make([
            'client_key' => $this->provider->clientId(),
            'timestamp' => (string) new Timestamp($this->timestamp),
            'signature' => $this->signature(),
        ])->forGetAccessToken();
    }
}
