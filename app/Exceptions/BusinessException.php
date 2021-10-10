<?php


namespace App\Exceptions;

use App\Tools\Tool;
use Throwable;

/**
 * 功能：业务异常
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/
class BusinessException extends AbstractException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message ?: Tool::message('businessExp'), $code ?: Tool::code('businessExp'), $previous);
    }
}