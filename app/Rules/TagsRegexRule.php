<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagsRegexRule implements Rule
{
    private $pattern;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pattern = '/^\d+(,\s*\d+\s*)*$/';
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
        return 'The tags format is invalid. The tags format accepts only numbers separated by commas and ends without the trailing comma.';
    }
}
