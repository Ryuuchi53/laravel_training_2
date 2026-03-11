<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
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
        throw new HttpResponseException(
            redirect()->route('users.create')
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
            'name.required' => 'Nama diperlukan',
            'name.max' => 'Nama tidak boleh melebihi :max aksara',
            'email.required' => 'Emel diperlukan',
            'email.email' => 'Emel tidak sah',
            'email.unique' => 'Emel sudah digunakan',
            'password.required' => 'Kata laluan diperlukan',
            'password.min' => 'Kata laluan mesti sekurang-kurangnya :min aksara',
            'password.confirmed' => 'Kata laluan dan pengesahan tidak sepadan',
        ];
    }
}
