<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

use Exception;
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

    public function publicKey(): ?PublicKey
    {
        return $this->config->publicKey() ?? null;
    }

    public function baseUrl(): ?string
    {
        return $this->config->baseUrl();
    }

    public function relativePath(string $endpoint): string
    {
        if (preg_match('/access-token/', $endpoint)) {
            return $this->config->apiPrefix().$endpoint;
        }

        return $this->config->serviceApiPrefix()
            ? $this->config->serviceApiPrefix().$endpoint
            : $this->config->apiPrefix().$endpoint;
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

    public static function init(string $name, array $options = []): Provider
    {
        if (! function_exists('config')) {
            throw new Exception('`config` function not exists');
        }

        $config = config("snap.providers.{$name}");

        Config::load($options['origin'] ?? '');

        if (isset($options['client'])) {
            Config::useClient($options['client']);
        }

        return new Provider($name, new ProviderConfig(
            partnerId: $config['partner_id'],
            clientId: $config['client_id'],
            clientSecret: $config['client_secret'],
            privateKey: $config['private_key'] ? storage_path($config['private_key']) : null,
            publicKey: $config['public_key'] ? storage_path($config['public_key']) : null,
            channelId: $config['channel_id'],
            baseUrl: $config['host'],
            apiPrefix: $config['api_prefix'],
            serviceApiPrefix: $config['service_api_prefix'] ?? null,
            logChannel: $config['log_channel'] ?? null,
        ));
    }

    public static function load(string $name, array $options): Provider
    {
        return static::init($name, $options);
    }
}
