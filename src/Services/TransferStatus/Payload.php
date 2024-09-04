<?php

namespace QuetzalStudio\PhpSnapBi\Services\TransferStatus;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public ?string $originalPartnerReferenceNo = null,
        public ?string $originalReferenceNo = null,
        public ?string $originalExternalId = null,
        public string $serviceCode = '17',
        public ?string $transactionDate = null,
        public ?Amount $amount = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'originalPartnerReferenceNo' => $this->originalPartnerReferenceNo,
            'originalReferenceNo' => $this->originalReferenceNo,
            'originalExternalId' => $this->originalExternalId,
            'serviceCode' => $this->serviceCode,
            'transactionDate' => $this->transactionDate,
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
