<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Signature;

use QuetzalStudio\PhpSnapBi\Config;
use QuetzalStudio\PhpSnapBi\Timestamp;

class AccessTokenSignaturePayload
{
    public function __construct(protected string $clientId, protected string|int $timestamp)
    {
        //
    }

    public function __toString()
    {
        $timestamp = (string) new Timestamp($this->timestamp);

        $stringToSign = "{$this->clientId}|{$timestamp}";

        if (Config::isDebug() && Config::hasLogger()) {
            Config::logger()->debug(__CLASS__, [
                'string_to_sign' => $stringToSign,
            ]);
        }

        return $stringToSign;
    }
}
