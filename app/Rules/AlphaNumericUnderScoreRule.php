<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumericUnderScoreRule implements Rule
{
    public $attribute;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-zA-Z0-9_]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The ' . $this->attribute . ' must only contain letters, numbers and underscores.';
    }
}
