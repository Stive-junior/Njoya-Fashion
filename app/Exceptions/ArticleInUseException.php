<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class ArticleInUseException extends Exception
{
 protected $users;

    public function __construct($users, $message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->users = $users;
    }

    public function getUsers()
    {
        return $this->users;
    }
}