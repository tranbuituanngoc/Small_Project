<?php

namespace App\Exceptions;

use Exception;

class MessageException extends Exception
{
    protected $message;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->message = $message;
    }

    public function getMessageForUser()
    {
        return $this->message;
    }
}
