<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostCreateRequest extends FormRequest
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
            'title' => 'string|required_without:body|max:100',
            'body' => 'string|required_without:title|max:400'
        ];
    }

    public function messages() : array
    {
        return [
            'title.string' => 'Post title must be string',
            'title.required_without:body' => 'Post title or Body are Required',
            'title.max' => 'Post title must be max. :max characters',
            'body.string' => 'Post body must be string',
            'body.required_without:title' => 'Post title or Body are Required',
            'body.max' => 'Post body must be max. :max characters',
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
