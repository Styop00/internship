<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'body' => 'string|nullable|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => "Post's title is required",
            'title.string' => "Post's title must be string",
            'title.max' => "Post's title must be max. :max characters",
            'body.string' => "Post's body must be string",
            'body.max' => "Post's body must be max. :max characters",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
