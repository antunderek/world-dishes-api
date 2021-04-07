<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WithAllowedRule implements Rule
{
    private $allowed;
    private $allowedString;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->allowed = ['tags', 'ingredients', 'category'];
        $this->allowedString = implode(', ', $this->allowed);
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
        $withs = array_map('trim', (explode(',', $value)));
        if (count($withs) > count($this->allowed)) {
            return false;
        }
        foreach ($withs as $with) {
            if (!in_array(strtolower($with), $this->allowed)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The with format is invalid. The strings should be separated by commas without the trailing comma. The with format only accepts the following strings: {$this->allowedString}.";
    }
}
