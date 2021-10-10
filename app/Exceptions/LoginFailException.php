<?php


namespace App\Exceptions;

use App\Tools\Tool;
use Throwable;

/**
 * 功能：登陆失败异常
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class LoginFailException extends AbstractException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: Tool::message('loginFail'), $code ?: Tool::code('loginFail'), $previous);
    }
}