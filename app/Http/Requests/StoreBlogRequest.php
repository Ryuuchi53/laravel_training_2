<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * 🔥 AUTO ADD created_by before validation
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => auth()->id(), // 👈 AUTO FROM TOKEN
        ]);
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'isDone' => 'integer|in:0,1', // Optional, but if provided must be 0 or 1

            // now NOT required from client anymore
            'created_by' => 'required|integer|exists:users,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $firstMessage = $validator->errors()->first();

        if ($this->is('api/blogs-api*')) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => $firstMessage,
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        throw new HttpResponseException(
            redirect()->route('blogs.create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Check your input.')
        );
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title cannot exceed :max characters',
            'content.required' => 'Description is required',

            'created_by.required' => 'User not found (invalid token).',
            'created_by.integer' => 'User ID must be a number.',
            'created_by.exists' => 'User does not exist in the system.',
        ];
    }
}