<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitStatus;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as ContractsAdditionalInfo;

class AdditionalInfo implements ContractsAdditionalInfo
{
    public function toArray(): array
    {
        $data = [];

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
