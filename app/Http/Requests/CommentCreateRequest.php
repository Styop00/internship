<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CommentCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'text' => "required|string|max:255",
            'post_id' => "required|integer",
            'parent_id' => "integer|nullable",
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => "Comment`s title is required",
            'text.string' => "Comment`s title must be string",
            'text.max' => "Comment`s title must be max. :max characters",
            'post_id.required' => "Comment`s post_id is required",
            'post_id.integer' => "Comment`s post_id must be integer",
            'parent_id.required' => "Comment`s parent_id is required",
            'parent_id.integer' => "Comment`s parent_id must be integer"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
