<?php

namespace QuetzalStudio\PhpSnapBi\Services\InterbankTransfer;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $partnerReferenceNo,
        public Amount $amount,
        public string $beneficiaryAccountName,
        public string $beneficiaryAccountNo,
        public string $beneficiaryBankCode,
        public string $sourceAccountNo,
        public string $transactionDate,
        public ?string $beneficiaryEmail = null,
        public ?string $currency = null,
        public ?string $customerReference = null,
        public ?string $feeType = null,
        public ?string $remark = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNo,
            'amount' => $this->amount->toArray(),
            'beneficiaryAccountName' => $this->beneficiaryAccountName,
            'beneficiaryAccountNo' => $this->beneficiaryAccountNo,
            'sourceAccountNo' => $this->sourceAccountNo,
            'beneficiaryBankCode' => $this->beneficiaryBankCode,
            'transactionDate' => $this->transactionDate,
            'beneficiaryEmail' => $this->beneficiaryEmail,
            'currency' => $this->currency,
            'customerReference' => $this->customerReference,
            'feeType' => $this->feeType,
            'remark' => $this->remark,
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
