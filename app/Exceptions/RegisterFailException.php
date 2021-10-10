<?php


namespace App\Exceptions;

use App\Tools\Tool;
use Throwable;

/**
 * 功能：注册失败异常
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class RegisterFailException extends AbstractException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: Tool::message('registerFail'), $code ?: Tool::code('registerFail'), $previous);
    }
}