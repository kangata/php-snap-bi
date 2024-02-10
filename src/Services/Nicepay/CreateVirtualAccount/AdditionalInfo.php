<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\CreateVirtualAccount;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as ContractsAdditionalInfo;

class AdditionalInfo implements ContractsAdditionalInfo
{
    public function __construct(
        protected string $bankCode,
        protected string $goodsName,
        protected string $notificationUrl,
        protected ?string $virtualAccountValidDate = null,
        protected ?string $virtualAccountValidTime = null,
        protected ?string $merchantSellerId = null,
        protected ?string $merchantSellerFee = null,
        protected ?string $merchantSellerFeeType = null,
        protected ?string $merchantBalanceFee = null,
        protected ?string $merchantBalanceFeeType = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'bankCd' => $this->bankCode,
            'goodsNm' => $this->goodsName,
            'dbProcessUrl' => $this->notificationUrl,
            'vacctValidDt' => $this->virtualAccountValidDate,
            'vacctValidTm' => $this->virtualAccountValidTime,
            'msId' => $this->merchantSellerId,
            'msFee' => $this->merchantSellerFee,
            'msFeeType' => $this->merchantSellerFeeType,
            'mbFee' => $this->merchantBalanceFee,
            'mbFeeType' => $this->merchantBalanceFeeType,
        ];

        foreach ($data as $key => $val) {
            if (is_null($val)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
