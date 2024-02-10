<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

class Timestamp
{
    public function __construct(protected string|int $timestamp)
    {
        //
    }

    public function __toString()
    {
        return preg_match('/^\d{10}+/', (string) $this->timestamp)
            ? date(DATE_ATOM, (int) $this->timestamp)
            : $this->timestamp;
    }
}
