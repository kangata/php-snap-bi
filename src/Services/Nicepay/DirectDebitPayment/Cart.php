<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment;

class Cart
{
    protected int $count;

    protected array $items;

    public function __construct(array $items = [])
    {
        $this->count = count($items);
        $this->items = $items;
    }

    public function add(CartItem $item)
    {
        $this->items[] = $item;
    }

    public function toArray()
    {
        return [
            'count' => (string) $this->count,
            'item' => array_map(fn ($item) => $item->toArray(), $this->items),
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
