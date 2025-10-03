<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoDeviceRequest extends FormRequest
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
            'so_device_type_id' => ['required', 'integer'],
            'description' => ['required', 'string'],
            'brand' => ['required', 'string'],
            'model' => ['required', 'string'],
            'serial_number' => ['required', 'string'],
            'damages' => ['nullable', 'string'],
            'accessories' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'warranty_provider' => ['nullable', 'string'],
            'purchase_date' => ['nullable'],
            'reseller' => ['nullable', 'string'],
            'invoice_number' => ['nullable', 'string'],
            'warranty_certificate' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'so_device_type_id.required' => 'O tipo de dispositivo é obrigatório.',
            'description.required' => 'O dispositivo precisa de uma descrição.',
            'brand.required' => 'Defina a marca do dispositivo. Ou "nt" caso não tenha.',
            'model.required' => 'Defina o modelo do dispositivo.',
            'serial_number.required' => 'O número de série/IMEI é obrigatório.',
        ];
    }
}
