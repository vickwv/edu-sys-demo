<?php

/**
 * 功能：禁止输入表情
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/

namespace App\Rules;

use App\Tools\Tool;
use Illuminate\Contracts\Validation\Rule;

class NoEmoji implements Rule
{

    public function passes($attribute, $value)
    {
        return Tool::filterEmoji($value) == $value;
    }

    public function message()
    {
        return Tool::message("unsupportedEmoji");
    }
}