<?php

use \Exception as Exception;

class PetNotFoundException extends Exception
{
    public function __construct($message = "Pet not found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}