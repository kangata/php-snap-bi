<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

use QuetzalStudio\PhpSnapBi\Enums\UrlType;

class Url
{
    public function __construct(
        protected string $url,
        protected string|UrlType $type,
        protected bool $isDeepLink = false,
    ) {}

    public function toArray()
    {
        return [
            'url' => $this->url,
            'type' => is_string($this->type) ? $this->type : $this->type->name,
            'isDeeplink' => $this->isDeepLink ? 'Y' : 'N',
        ];
    }
}
