<?php

namespace QuetzalStudio\PhpSnapBi\Concerns;

use QuetzalStudio\PhpSnapBi\Client\HeaderFactory;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;
use QuetzalStudio\PhpSnapBi\Signature\ServiceSignature;
use QuetzalStudio\PhpSnapBi\Signature\ServiceSignaturePayload;

trait HasService
{
    public function useVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function version(): string
    {
        return $this->version ?? 'v1.0';
    }

    public function httpMethod(): string
    {
        return 'post';
    }

    public function send(?ServicePayload $payload = null)
    {
        if ($payload) {
            $this->payload = $payload;
        }

        return $this->client
            ->withHeaders($this->headers())
            ->{$this->httpMethod()}(
                $this->provider->serviceUrl($this->endpoint()),
                $this->payload(),
            );
    }

    public function endpoint(): string
    {
        return str_replace(':version', $this->version(), $this->endpoint);
    }

    public function signature(): string
    {
        return ServiceSignature::symmetric(
            $this->provider->clientSecret(),
            new ServiceSignaturePayload(
                strtoupper($this->httpMethod()),
                $this->provider->relativePath($this->endpoint()),
                (string) $this->accessToken,
                $this->timestamp,
                $this->payload->toArray(),
            ),
        );
    }

    public function headers(): array
    {
        return HeaderFactory::make([
            'authorization' => 'Bearer '.(string) $this->accessToken,
            'timestamp' => $this->timestamp,
            'signature' => $this->signature(),
            'origin' => Config::instance()->origin(),
            'partner_id' => $this->provider->partnerId(),
            'external_id' => (string) $this->externalId,
            'channel_id' => (string) $this->channelId,
        ])->toArray();
    }

    public function payload(): array
    {
        if (Config::hasClient()) {
            return $this->payload->toArray();
        }

        $data = [];

        if (in_array($this->httpMethod(), ['get'])) {
            $data['query'] = $this->payload->toArray();
        } else {
            $data['json'] = $this->payload->toArray();
        }

        return $data;
    }
}
