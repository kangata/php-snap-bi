<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

class ProviderConfig
{
    public function __construct(
        protected ?string $partnerId = null,
        protected ?string $clientId = null,
        protected ?string $clientSecret = null,
        protected ?string $privateKey = null,
        protected ?string $publicKey = null,
        protected ?string $baseUrl = null,
        protected ?string $apiPrefix = null,
    ) {
        //
    }

    public function load(array $options): void
    {
        $this->partnerId = $options['partner_id'] ?? null;
        $this->clientId = $options['client_id'] ?? null;
        $this->clientSecret = $options['client_secret'] ?? null;
        $this->baseUrl = $options['base_url'] ?? null;
        $this->apiPrefix = $options['api_prefix'] ?? null;
        $this->privateKey = $options['private_key'] ?? null;
        $this->publicKey = $options['public_key'] ?? null;
    }

    public function partnerId(): ?string
    {
        return $this->partnerId;
    }

    public function clientId(): ?string
    {
        return $this->clientId;
    }

    public function clientSecret(): ?string
    {
        return $this->clientSecret;
    }

    public function privateKey(): ?PrivateKey
    {
        return $this->privateKey ? new PrivateKey(path: $this->privateKey) : null;
    }

    public function publicKey(): ?string
    {
        return $this->publicKey;
    }

    public function baseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function apiPrefix(): ?string
    {
        return $this->apiPrefix;
    }

    public function relativePath(string $endpoint): string
    {
        return $this->apiPrefix.$endpoint;
    }

    public function serviceUrl(string $endpoint): string
    {
        return $this->baseUrl().$this->relativePath($endpoint);
    }
}
