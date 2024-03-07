<?php

namespace QuetzalStudio\PhpSnapBi\Services\Nicepay\DirectDebitPayment;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo as ContractsAdditionalInfo;

class AdditionalInfo implements ContractsAdditionalInfo
{
    public function __construct(
        protected string $partnerCode,
        protected string $goodsName,
        protected string $billingName,
        protected string $billingPhone,
        protected string $callbackUrl,
        protected string $dbProcessUrl,
        protected ?string $cartData = null,
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
            'mitraCd' => $this->partnerCode,
            'goodsNm' => $this->goodsName,
            'billingNm' => $this->billingName,
            'billingPhone' => $this->billingPhone,
            'callBackUrl' => $this->callbackUrl,
            'dbProcessUrl' => $this->dbProcessUrl,
            'cartData' => $this->cartData,
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
