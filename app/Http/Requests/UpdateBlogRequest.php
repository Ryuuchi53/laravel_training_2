<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // you may add authorization logic if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $blogId = $this->route('blog');

        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'created_by' => 'required' . $blogId
        ];
    }

    /**
     * Handle a failed validation attempt by redirecting back with the
     * same error/message structure the controller previously used.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $blogId = $this->route('blog');

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
            redirect()->route('blogs.edit', $blogId)
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Sila semak semula')
        );
    }

    /**
     * Custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Tajuk diperlukan',
            'title.max' => 'Tajuk tidak boleh melebihi :max aksara',
            'content.required' => 'Keterangan diperlukan',
            'created_by.required' => 'Id Pengguna diperlukan.'
        ];
    }
}
