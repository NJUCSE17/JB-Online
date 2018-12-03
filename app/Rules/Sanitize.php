<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Sanitize.
 */
class Sanitize implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        clean($value);
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Sanitize failed.";
    }
}
