<?php

namespace App\Rules;

use App\Language;
use Illuminate\Contracts\Validation\Rule;

class LanguageExistsRule implements Rule
{
    private $supportedLanguages;
    private $supportedLanguagesString;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->supportedLanguages = Language::pluck('lang')->toArray();
        $this->supportedLanguagesString = implode(', ', $this->supportedLanguages);
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
        return in_array($value, $this->supportedLanguages);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The selected language is not supported. Supported languages: {$this->supportedLanguagesString}";
    }
}
