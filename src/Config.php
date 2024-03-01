<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

use Psr\Log\LoggerInterface;

class Config
{
    protected static ?Config $instance = null;

    protected static bool $debug = false;

    protected static ?LoggerInterface $logger = null;

    protected static $client = null;

    protected static $cache = null;

    public function __construct(protected string $origin, protected ?PrivateKey $privateKey = null)
    {
        //
    }

    public function privateKey(): ?PrivateKey
    {
        return $this->privateKey;
    }

    public function origin(): string
    {
        return $this->origin;
    }

    public static function instance(): ?static
    {
        return static::$instance;
    }

    public static function load(string $origin, ?PrivateKey $privateKey = null): static
    {
        return static::$instance = new static($origin, $privateKey);
    }

    public static function debug(bool $debug): void
    {
        static::$debug = $debug;
    }

    public static function isDebug(): bool
    {
        return static::$debug;
    }

    public static function useLogger(LoggerInterface $logger): void
    {
        static::$logger = $logger;
    }

    public static function hasLogger(): bool
    {
        return ! is_null(static::$logger);
    }

    public static function logger(): LoggerInterface
    {
        return static::$logger;
    }

    public static function useClient($client): void
    {
        static::$client = $client;
    }

    public static function hasClient(): bool
    {
        return ! is_null(static::$client);
    }

    public static function client()
    {
        if (! static::$client) {
            return null;
        }

        return clone static::$client;
    }

    public static function useCache($cache): void
    {
        static::$cache = $cache;
    }

    public static function hasCache(): bool
    {
        return ! is_null(static::$cache);
    }

    public static function cache()
    {
        return static::$cache;
    }
}
