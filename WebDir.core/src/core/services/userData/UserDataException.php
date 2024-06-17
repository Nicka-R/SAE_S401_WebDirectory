<?php

namespace web\directory\core\services\userData;

use Exception;
use Throwable;

class UserDataException extends Exception
{
    // Propriétés spécifiques si nécessaires

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString():string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}