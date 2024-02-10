<?php

namespace QuetzalStudio\PhpSnapBi\Client;

use GuzzleHttp\Client as GuzzleClient;
use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Provider;

class Client
{
    protected ?GuzzleClient $client = null;

    protected array $headers;

    public function __construct(protected Provider $provider)
    {
        $this->client = new GuzzleClient;
    }

    public function withHeaders(Header|array $headers): self
    {
        $this->headers = is_array($headers) ? $headers : $headers->toArray();

        return $this;
    }

    public function __call($method, $arguments)
    {
        if (Config::hasClient()) {
            if (in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
                return Config::client()
                    ->withHeaders($this->headers)
                    ->acceptJson()
                    ->{$method}(...$arguments);
            }

            return Config::client()->{$method}(...$arguments);
        }

        if (in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            $arguments[1] = array_merge($arguments[1] ?? [], ['headers' => $this->headers]);
        }

        return $this->client->{$method}(...$arguments);
    }
}
