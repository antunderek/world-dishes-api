<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CategoryRegexRule implements Rule
{
    private $pattern;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pattern = "/^(\s*|\s*\d+\s*|NULL|!NULL)$/i";
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
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
        return 'The category format is invalid. The category format accepts only a number or one of the strings: null, !null';
    }
}
