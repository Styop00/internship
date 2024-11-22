<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "name" => "required|string|max:255",
            "address" => "nullable|string",
//            'email' => 'required|email:rfc,dns|unique:companies,email',
            "email" => "required|email:rfc,dns",
            "owner.*name" => "required|string|max:255",
//            'owner.*email' => 'required|email:rfc,dns|unique:owner,email',
            "owner.*email" => "required|email:rfc,dns",
            "employees.*.name" => "required|string|max:255",
//            'employees.*email' => 'required|email:rfc,dns|unique:employees,email',
            "employees.*.email" => "required|email:rfc,dns",
            "employees.*.position" => "required|string|max:255|in:developer,qa,pm",
            "employees.*.projects" => "nullable|array",
            "employees.*.specification" => "string|required_if:employees.*.position,developer|in:fullstack,frontend,backend",
        ];
    }

    public function messages() : array
    {
        return [

        ];
    }
}
