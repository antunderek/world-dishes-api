<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DiffTimeRegexRule implements Rule
{
    private $pattern;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pattern = "/^\s*[1-9]\d*\s*$/";
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
        return preg_match($this->pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The diff_time format is invalid. The diff_time format accepts only a positive number.';
    }
}
