<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\CancelVirtualAccount;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $partnerServiceId,
        public string $customerNumber,
        public string $virtualAccountNumber,
        public string $trxId,
        public AdditionalInfo|array|null $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerServiceId' => $this->partnerServiceId,
            'customerNo' => $this->customerNumber,
            'virtualAccountNo' => $this->virtualAccountNumber,
            'trxId' => $this->trxId,
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
