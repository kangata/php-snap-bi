<?php

namespace QuetzalStudio\PhpSnapBi\Services\BCA\InterbankTransfer;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as WithAdditionalInfo;
use QuetzalStudio\PhpSnapBi\Enums\BIFastPurposeCode;
use QuetzalStudio\PhpSnapBi\Enums\TransferType;

class AdditionalInfo implements WithAdditionalInfo
{
    public function __construct(
        protected TransferType|string $transferType,
        protected BIFastPurposeCode|string $purposeCode,
    ) {
        //
    }

    public function toArray(): array
    {
        return [
            'transferType' => is_string($this->transferType)
                ? $this->transferType
                : $this->transferType->value,
            'purposeCode' => is_string($this->purposeCode)
                ? $this->purposeCode
                : $this->purposeCode->value,
        ];
    }
}
