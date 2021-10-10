<?php

/**
 * 功能：防御XSS
 *
 * @author: stevenv
 * @date: 2021-10-10
 **/

namespace App\Rules;

use App\Tools\Tool;
use Illuminate\Contracts\Validation\Rule;

class NoXss implements Rule
{

    public function passes($attribute, $value)
    {
        return htmlspecialchars($value, ENT_NOQUOTES) == $value;
    }

    public function message()
    {
        return Tool::message("defenseXss");
    }
}