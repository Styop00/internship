<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'likeable_id' => 'required|integer',
            'likeable_type' => 'required|string|in:post,comment',
        ];
    }

    public function messages(): array
    {
        return [
            'likeable_id.required' => 'The ID of the item to like is required.',
            'likeable_type.required' => 'The type of the item to like is required.',
            'likeable_type.in' => 'The type must be either "post" or "comment".',
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
