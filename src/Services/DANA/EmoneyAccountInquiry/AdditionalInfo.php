<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyAccountInquiry;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as WithAdditionalInfo;
use QuetzalStudio\PhpSnapBi\Services\DANA\Enums\FundType;

class AdditionalInfo implements WithAdditionalInfo
{
    public function __construct(
        public FundType|string $fundType,
        public string $beneficiaryBankCode,
        public ?string $beneficiaryAccountName = null,
        public ?string $accountType = null,
        public ?string $accessToken = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'fundType' => is_string($this->fundType)
                ? $this->fundType
                : $this->fundType->name,
            'beneficiaryBankCode' => $this->beneficiaryBankCode,
            'beneficiaryAccountName' => $this->beneficiaryAccountName,
            'accountType' => $this->accountType,
            'accessToken' => $this->accessToken,
        ];

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
