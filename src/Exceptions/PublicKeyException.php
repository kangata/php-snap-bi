<?php

namespace QuetzalStudio\PhpSnapBi\Exceptions;

use Exception;

class PublicKeyException extends Exception
{
    public function __construct($message = 'Failed to read public key.')
    {
        parent::__construct($message);
    }
}
