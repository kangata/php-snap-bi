<?php

namespace QuetzalStudio\PhpSnapBi\Contracts;

interface Service
{
    public function useVersion(string $version): self;

    public function version(): string;

    public function send(?ServicePayload $payload = null);

    public function endpoint(): string;

    public function signature(): string;

    public function headers(): array;
}
