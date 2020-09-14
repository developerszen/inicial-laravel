<?php

namespace App\Validators;

class AlphaCustom
{
    function validate($attribute, $value, $params, $validator) {
        return preg_match('/^[\pL\.\s]+$/u', $value);
    }
}