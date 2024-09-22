<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FloatNumber implements Rule
{
    public function passes($attribute, $value)
    {
        if (is_numeric($value) && is_float($value + 0)) {
            return true;
        } elseif (is_numeric($value)) {
            return true;
        }
    }

    public function message()
    {
        return 'The :attribute must be a valid float or number.';
    }
}
