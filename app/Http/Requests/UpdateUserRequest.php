<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // grab the current vehicle id from route parameters
        $userId = $this->route('user');

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
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
        $userId = $this->route('user');

        throw new HttpResponseException(
            redirect()->route('users.edit', $userId)
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
            'email.unique' => 'Emel ini telah wujud',
        ];
    }
}
