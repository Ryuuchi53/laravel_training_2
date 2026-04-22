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
        if ($this->is('api/blogs-api*')) {
            throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => 'Sila semak semula',
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        throw new HttpResponseException(
            redirect()->route('blogs.create')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Sila semak semula')
        );
    }

    public function messages()
    {
        return [
            'title.required' => 'Tajuk diperlukan',
            'title.max' => 'Tajuk tidak boleh melebihi :max aksara',
            'content.required' => 'Keterangan diperlukan',

            'created_by.required' => 'User tidak dijumpai (token invalid).',
            'created_by.integer' => 'Id Pengguna mestilah nombor.',
            'created_by.exists' => 'User tidak wujud dalam sistem.',
        ];
    }
}