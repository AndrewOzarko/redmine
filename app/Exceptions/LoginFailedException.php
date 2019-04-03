<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class LoginFailedException extends Exception
{
    public $httpStatusCode = Response::HTTP_BAD_REQUEST;

    public $message = 'Login failed.';
}
