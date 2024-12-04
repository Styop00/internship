<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'text' => "required|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => "Comment's title is required",
            'text.string' => "Comment's title must be string",
            'text.max' => "Comment's title must be max. :max characters",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
