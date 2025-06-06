<?php

namespace QuetzalStudio\PhpSnapBi\Services\BalanceInquiry;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public ?string $partnerReferenceNo = null,
        public ?string $bankCardToken = null,
        public ?string $accountNo = null,
        public ?array $balanceTypes = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNo,
            'bankCardToken' => $this->bankCardToken,
            'accountNo' => $this->accountNo,
            'balanceTypes' => $this->balanceTypes,
        ];

        if ($this->additionalInfo) {
            $data['additionalInfo'] = $this->additionalInfo instanceof AdditionalInfo
                ? $this->additionalInfo->toArray()
                : $this->additionalInfo;
        }

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
