<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\CancelVirtualAccount;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as ContractsAdditionalInfo;

class AdditionalInfo implements ContractsAdditionalInfo
{
    public function __construct(
        protected Amount $totalAmount,
        protected string $trxIdVa,
        protected string $cancelMessage,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'totalAmount' => $this->totalAmount->toArray(),
            'tXidVA' => $this->trxIdVa,
            'cancelMessage' => $this->cancelMessage,
        ];

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
