<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

use GuzzleHttp\Client;
use QuetzalStudio\PhpSnapBi\Services\Auth\B2BAccessToken\GetAccessToken;

class Provider
{
    public function __construct(protected string $name, protected ProviderConfig $config)
    {
        $this->name = preg_replace('/[^a-z0-9]/', '-', strtolower(trim($name)));
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function config(): ProviderConfig
    {
        return $this->config;
    }

    public function partnerId(): ?string
    {
        return $this->config->partnerId();
    }

    public function clientId(): ?string
    {
        return $this->config->clientId();
    }

    public function clientSecret(): ?string
    {
        return $this->config->clientSecret();
    }

    public function privateKey(): ?PrivateKey
    {
        return $this->config->privateKey() ?? null;
    }

    public function publicKey(): ?string
    {
        return $this->config->publicKey();
    }

    public function baseUrl(): ?string
    {
        return $this->config->baseUrl();
    }

    public function relativePath(string $endpoint): string
    {
        return $this->config->apiPrefix().$endpoint;
    }

    public function serviceUrl(string $endpoint): string
    {
        return $this->baseUrl().$this->relativePath($endpoint);
    }

    public function getAccessToken(): string
    {
        if (Config::hasCache() && Config::cache()->has($this->cacheKey())) {
            return Config::cache()->get($this->cacheKey());
        }

        if (! Config::hasClient() || Config::client() instanceof Client) {
            $response = (new GetAccessToken($this, Config::instance()))->send();

            $body = json_decode((string) $response->getBody());

            $response->getBody()->rewind();

            if (Config::hasCache()) {
                Config::cache()->put(
                    "snap.{$this->name}.token",
                    $body->accessToken,
                    $body->expiresIn
                );
            }

            return $body->accessToken;
        }

        $response = (new GetAccessToken($this, Config::instance()))->send();

        if (Config::hasCache()) {
            Config::cache()->put(
                $this->cacheKey(),
                $response->json('accessToken'),
                $response->json('expiresIn')
            );
        }

        return $response->json('accessToken');
    }

    private function cacheKey(): string
    {
        return "snap.{$this->name}.{$this->clientId()}.token";
    }
}
