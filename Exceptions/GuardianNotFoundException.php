<?php

use \Exception as Exception;

class GuardianNotFoundException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message = "Guardian not found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}