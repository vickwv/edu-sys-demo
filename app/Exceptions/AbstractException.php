<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class AbstractException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render() {
        return response()->json([
           'code' => $this->getCode(),
           'msg'  => $this->getMessage(),
        ], 200);
    }
}
