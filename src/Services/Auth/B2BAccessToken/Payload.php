<?php

namespace QuetzalStudio\PhpSnapBi\Services\Auth\B2BAccessToken;

use QuetzalStudio\PhpSnapBi\Contracts\AdditionalInfo;
use QuetzalStudio\PhpSnapBi\Contracts\ServicePayload;

class Payload implements ServicePayload
{
    public function __construct(
        protected string $grantType = 'client_credentials',
        protected ?AdditionalInfo $additionalInfo = null,
    ) {
        //
    }

    public function toArray(): array
    {
        $data = [
            'grantType' => $this->grantType,
        ];

        if (! is_null($this->additionalInfo)) {
            $data['additionalInfo'] = $this->additionalInfo->toArray();
        }

        return $data;
    }
}
