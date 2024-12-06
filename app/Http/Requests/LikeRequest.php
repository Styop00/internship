<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LikeRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'likeable_id' => "required|integer",
            'likeable_type' => "required|string|in:post,comment"
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'likeable_id.required' => "ID of the liked item is required",
            'likeable_id.integer' => "ID of the liked item must be integer",
            'likeable_type.required' => "The type of the liked item must be required",
            'likeable_type.string' => "The type of liked item must be string",
            'likeable_type.' => "The type of liked item must be 'post' or 'comment'"
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => $validator->messages()->first()
        ]));
    }
}
