<?php
class UserNotFoundException extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message = "User not found", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
