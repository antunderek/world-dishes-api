<?php

namespace App\Http\Requests;

use App\Rules\{
    CategoryRegexRule,
    DiffTimeRegexRule,
    LanguageExistsRule,
    TagsRegexRule,
    WithAllowedRule
};
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class MealsGetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'per_page' => 'integer',
            'tags' => new TagsRegexRule(),
            'lang' => ['required', 'string', 'min:2', new LanguageExistsRule()],
            'with' => ['string', new WithAllowedRule()],
            'diff_time' => ['integer', new DiffTimeRegexRule()],
            'category' => new CategoryRegexRule(),
            'page' => 'integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
