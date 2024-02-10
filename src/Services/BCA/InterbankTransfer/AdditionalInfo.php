<?php

namespace QuetzalStudio\PhpSnapBi\Services\BCA\InterbankTransfer;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as WithAdditionalInfo;
use QuetzalStudio\PhpSnapBi\Enums\BIFastPurposeCode;
use QuetzalStudio\PhpSnapBi\Enums\TransferType;

class AdditionalInfo implements WithAdditionalInfo
{
    public function __construct(
        protected TransferType $transferType,
        protected BIFastPurposeCode $purposeCode,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'transferType' => $this->transferType->value,
            'purposeCode' => $this->purposeCode->value,
        ];
    }
}
