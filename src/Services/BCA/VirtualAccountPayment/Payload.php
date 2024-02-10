<?php

namespace QuetzalStudio\PhpSnapBi\Services\BCA\VirtualAccountPayment;

use QuetzalStudio\PhpSnapBi\Amount;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        public string $partnerReferenceNo,
        public string $virtualAccountNo,
        public Amount $paidAmount,
        public ?string $virtualAccountEmail = null,
        public ?string $sourceAccountNo = null,
        public ?string $trxDateTime = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'partnerReferenceNo' => $this->partnerReferenceNo,
            'paidAmount' => $this->paidAmount->toArray(),
            'virtualAccountNo' => $this->virtualAccountNo,
            'virtualAccountEmail' => $this->virtualAccountEmail,
            'sourceAccountNo' => $this->sourceAccountNo,
            'trxDateTime' => $this->trxDateTime,
        ];

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
