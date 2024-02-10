<?php

namespace QuetzalStudio\PhpSnapBi\Exceptions;

use Exception;

class SignatureException extends Exception
{
    public function __construct($message = 'Failed to generate signature.')
    {
        parent::__construct($message);
    }
}
