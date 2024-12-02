<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '*' => 'required',
            'owner.*' => 'required',
            'employees.*.*' => 'required',
            'email' => 'email',
            'employees.*.position' => 'in:developer,qa,pm',
            'employees.*.specification' => 'required_if:position,developer|in:fullstack,frontend,backend',
        ];
    }


    /**
     * @param Validator $validator
     * @return string
     */
    public function failedValidation(Validator $validator) : string {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first(),
        ]));
    }
}
