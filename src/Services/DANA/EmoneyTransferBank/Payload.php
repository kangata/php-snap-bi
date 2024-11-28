<?php declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\DANA\EmoneyTransferBank;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $beneficiaryAccountNumber,
        public string $beneficiaryBankCode,
        public Amount $amount,
        public ?string $partnerReferenceNo = null,
        public ?string $customerNumber = null,
        public ?string $accountType = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNo,
            'customerNumber' => $this->customerNumber,
            'accountType' => $this->accountType,
            'beneficiaryAccountNumber' => $this->beneficiaryAccountNumber,
            'beneficiaryBankCode' => $this->beneficiaryBankCode,
            'amount' => $this->amount->toArray(),
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
