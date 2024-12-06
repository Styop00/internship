<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Http\Exceptions\HttpResponseException;

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
            'name' => 'required|string|max:255',
//            'email' => 'required|email:rfc,dns|unique:companies,email',
            'address' => 'nullable|string',
            'email' => 'required|email:rfc,dns',
            'owner.*name' => 'required|string|max:255',
//            'owner.*email' => 'required|email',
            'owner.*email' => 'required|email:rfc,dns',
            'employees.*.name' => 'required|string|max:255',
//            'employees.*.email' => 'required|email:rfc,dns|unique:employees,email',
            'employees.*.email' => 'required|email:rfc,dns',
            'employees.*.position' => 'required|string|max:255|in:developer,qa,pm',
            'employees.*.projects' => 'nullable|array',
            'employees.*.specification' => 'string|required_if:employees.*.position,developer|in:1,2,3',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.max' => 'A name must be max. :max characters',
            'address.string' => 'The address must be a string.',
            'email.required' => 'The company email is required.',
            'email.unique' => 'This company email is already in use.',

            'owner.name.required' => 'The owner\'s name is required.',
            'owner.email.required' => 'The owner\'s email is required.',
            'owner.email.unique' => 'The owner\'s email is already in use.',

            'employees.required' => 'At least one employee is required.',
            'employees.*.name.required' => 'Each employee\'s name is required.',
            'employees.*.email.required' => 'Each employee\'s email is required.',
            'employees.*email.unique' => 'This employee email is already in use.',
            'employees.*.position.required' => 'Each employee\'s position is required.',
            'employees.*.position.in' => 'The position must be one of: developer, qa, pm.',
            'employees.*.projects.required' => 'Each employee must be assigned at least one project.',
            'employees.*.projects.array' => 'Each project must be array.',
            'employees.*.required_if.in' => 'The specification must be one of: fullstack, frontend, backend.',
            'employees.*.specification.required_if' => 'The specification of developer position can be one of: fullstack, frontend, backend.',
        ];
    }

    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
