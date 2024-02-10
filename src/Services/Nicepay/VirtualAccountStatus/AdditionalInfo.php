<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\VirtualAccountStatus;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as ContractsAdditionalInfo;

class AdditionalInfo implements ContractsAdditionalInfo
{
    public function __construct(
        protected Amount $totalAmount,
        protected string $trxId,
        protected string $trxIdVa,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'totalAmount' => $this->totalAmount->toArray(),
            'trxId' => $this->trxId,
            'tXidVA' => $this->trxIdVa,
        ];
    }
}
