<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $partnerReferenceNumber,
        public string $merchantId,
        public Amount $amount,
        public array $urls,
        public ?string $subMerchantId = null,
        public ?string $externalStoreId = null,
        public ?string $pointOfInitiation = null,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNumber,
            'merchantId' => $this->merchantId,
            'amount' => $this->amount->toArray(),
            'urlParam' => $this->urls,
            'subMerchantId' => $this->subMerchantId,
            'externalStoreId' => $this->externalStoreId,
            'pointOfInitiation' => $this->pointOfInitiation,
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
