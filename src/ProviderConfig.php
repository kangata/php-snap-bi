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
        protected ?string $channelId = null,
        protected ?string $baseUrl = null,
        protected ?string $apiPrefix = null,
        protected ?string $serviceApiPrefix = null,
        protected ?string $logChannel = null,
    ) {
        //
    }

    public function load(array $options): void
    {
        $this->partnerId = $options['partner_id'] ?? null;
        $this->clientId = $options['client_id'] ?? null;
        $this->clientSecret = $options['client_secret'] ?? null;
        $this->privateKey = $options['private_key'] ?? null;
        $this->publicKey = $options['public_key'] ?? null;
        $this->channelId = $options['channel_id'] ?? null;
        $this->baseUrl = $options['base_url'] ?? null;
        $this->apiPrefix = $options['api_prefix'] ?? null;
        $this->serviceApiPrefix = $options['service_api_prefix'] ?? null;
        $this->logChannel = $options['log_channel'] ?? null;
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

    public function publicKey(): ?PublicKey
    {
        return $this->publicKey ? new PublicKey(path: $this->publicKey) : null;
    }

    public function channelId(): ?string
    {
        return $this->channelId;
    }

    public function baseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function apiPrefix(): ?string
    {
        return $this->apiPrefix;
    }

    public function serviceApiPrefix(): ?string
    {
        return $this->serviceApiPrefix;
    }

    public function logChannel(): ?string
    {
        return $this->logChannel;
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
