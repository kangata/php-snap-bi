<?php

namespace QuetzalStudio\PhpSnapBi\Contracts;

use QuetzalStudio\PhpSnapBi\PrivateKey;

interface ServiceSignature
{
    public function __construct(
        PrivateKey $privateKey,
        string $clientSecret,
        string $payload
    );

    public function __toString();
}
