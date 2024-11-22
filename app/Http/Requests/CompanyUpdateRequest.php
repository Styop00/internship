<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'employees.*.position' => 'required|string|max:255|in:developer,qa,pm',
            'employees.*.specification' => 'string|required_if:employees.*.position,developer|in:fullstack,frontend,backend',
        ];
    }

    public function messages()
    {
        return [
            'employees.*.position.required' => 'Each employee\'s position is required.',
            'employees.*.position.in' => 'The position must be one of: developer, qa, pm.',
            'employees.*.specification.required_if' => 'The specification of developer position can be one of: fullstack, frontend, backend.',
        ];
    }
}
