<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

class Amount
{
    public function __construct(protected float $value, protected string $currency = 'IDR')
    {
        //
    }

    public function toArray()
    {
        return [
            'value' => number_format($this->value, 2, '.', ''),
            'currency' => $this->currency,
        ];
    }
}
