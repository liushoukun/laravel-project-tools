<?php

namespace Liushoukun\LaravelProjectTools\Rules;

use Illuminate\Contracts\Validation\Rule;

class NicknameRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value) : bool
    {
        if (!preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u', $value)) {
            return false;
        }
        return true;

    }

    public function message() : string
    {
        return ':attribute 只能包含中文、英文、数字';
    }
}
