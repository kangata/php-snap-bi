<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitStatus;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $merchantId,
        public string $referenceNumber,
        public string $partnerReferenceNumber,
        public string $serviceCode,
        public Amount $amount,
        public ?string $subMerchantId = null,
        public ?string $externalStoreId = null,
        public ?string $transactionDate = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'merchantId' => $this->merchantId,
            'originalReferenceNo' => $this->referenceNumber,
            'originalPartnerReferenceNo' => $this->partnerReferenceNumber,
            'serviceCode' => $this->serviceCode,
            'amount' => $this->amount->toArray(),
            'subMerchantId' => $this->subMerchantId,
            'externalStoreId' => $this->externalStoreId,
            'transactionDate' => $this->transactionDate,
        ];

        if (! is_null($this->additionalInfo)) {
            $data['additionalInfo'] = $this->additionalInfo instanceof AdditionalInfo
                ? $this->additionalInfo->toArray()
                : $this->additionalInfo;

            if (empty($data['additionalInfo'])) {
                $data['additionalInfo'] = (object) [];
            }
        }

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
