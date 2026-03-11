<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateVehicleRequest extends FormRequest
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
        $vehicleId = $this->route('vehicle');

        return [
            'model' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'make' => 'required|string|max:255',
            'year' => 'required|max:10',
            'brand' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate,' . $vehicleId,
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
        $vehicleId = $this->route('vehicle');

        throw new HttpResponseException(
            redirect()->route('vehicles.edit', $vehicleId)
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
            'model.required' => 'Model diperlukan',
            'model.max' => 'Model tidak boleh melebihi :max aksara',
            'color.required' => 'Warna diperlukan',
            'color.max' => 'Warna tidak boleh melebihi :max aksara',
            'make.required' => 'Buatan diperlukan',
            'make.max' => 'Buatan tidak boleh melebihi :max aksara',
            'year.required' => 'Tahun diperlukan',
            'year.max' => 'Tahun tidak boleh melebihi :max digit',
            'brand.required' => 'Jenama diperlukan',
            'brand.max' => 'Jenama tidak boleh melebihi :max aksara',
            'license_plate.required' => 'Nombor Pendaftaran diperlukan',
            'license_plate.max' => 'Nombor Pendaftaran tidak boleh melebihi :max aksara',
            'license_plate.unique' => 'Nombor Pendaftaran ini telah wujud',
        ];
    }
}
