<?php

declare(strict_types=1);

namespace QuetzalStudio\PhpSnapBi;

use OpenSSLAsymmetricKey;
use QuetzalStudio\PhpSnapBi\Exceptions\PublicKeyException;

class PublicKey
{
    protected OpenSSLAsymmetricKey|bool|null $value = null;

    public function __construct(protected ?string $content = null, protected ?string $path = null)
    {
        if (! $this->validate()) {
            throw new PublicKeyException;
        }
    }

    protected function getContent(): string
    {
        return $this->content ?? file_get_contents($this->path);
    }

    protected function validate(): bool
    {
        $this->value = openssl_get_publickey($this->getContent());

        return $this->value === false ? false : true;
    }

    public function value(): OpenSSLAsymmetricKey
    {
        return openssl_get_publickey($this->getContent());
    }

    public function __toString()
    {
        return $this->getContent();
    }
}
