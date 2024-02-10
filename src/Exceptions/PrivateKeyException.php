<?php

namespace QuetzalStudio\PhpSnapBi\Exceptions;

use Exception;

class PrivateKeyException extends Exception
{
    public function __construct($message = 'Failed to read private key.')
    {
        parent::__construct($message);
    }
}
