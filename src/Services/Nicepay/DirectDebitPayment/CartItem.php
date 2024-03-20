<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment;

class CartItem
{
    public function __construct(
        protected string $name,
        protected string $description,
        protected string $image,
        protected string|int $amount,
        protected string|int $quantity,
    ) {}

    public function toArray()
    {
        return [
            'goods_name' => $this->name,
            'goods_detail' => $this->description,
            'img_url' => $this->image,
            'goods_amt' => number_format((float) $this->amount, 2, '.', ''),
            'goods_quantity' => (string) $this->quantity,
        ];
    }
}
