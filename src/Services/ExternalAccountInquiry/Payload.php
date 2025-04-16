<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi\Services\ExternalAccountInquiry;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $beneficiaryBankCode,
        public string $beneficiaryAccountNo,
        public ?string $partnerReferenceNo = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNo,
            'beneficiaryBankCode' => $this->beneficiaryBankCode,
            'beneficiaryAccountNo' => $this->beneficiaryAccountNo,
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
