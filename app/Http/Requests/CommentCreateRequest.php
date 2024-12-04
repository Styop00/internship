<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentCreateRequest extends FormRequest
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
            'user_id' => "required|integer",
            'post_id' => "required|integer",
            'parent_id' => "integer|nullable",
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => "Comment's title is required",
            'text.string' => "Comment's title must be string",
            'text.max' => "Comment's title must be max. :max characters",
            'user_id.required' => "Comment's user_id is required",
            'user_id.integer' => "Comment's user_id must be integer",
            'post_id.required' => "Comment's post_id is required",
            'post_id.integer' => "Comment's post_id must be integer",
            'parent_id.required' => "Comment's parent_id is required",
            'parent_id.integer' => "Comment's parent_id must be integer",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
