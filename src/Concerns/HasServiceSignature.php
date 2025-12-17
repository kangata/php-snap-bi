<?php

namespace QuetzalStudio\PhpSnapBi\Concerns;

use QuetzalStudio\PhpSnapBi\PrivateKey;

trait HasServiceSignature
{
    public function __construct(
        protected PrivateKey $privateKey,
        protected string $clientSecret,
        protected string $payload
    ) {}
}
