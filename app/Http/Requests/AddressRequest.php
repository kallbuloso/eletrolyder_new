<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'tenant_id' => ['required', 'exists:tenants,id'],
            'type' => ['required', 'string'],
            'street' => ['required', 'string'],
            'number' => ['required', 'string'],
            'complement' => ['nullable', 'string'],
            'neighborhood' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'zip_code' => ['required', 'string'],
            'reference' => ['nullable', 'string']
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

            'type.required' => 'Tipo obrigatório.',
            'street.required' => 'Logradouro obrigatório.',
            'number.required' => 'Número obrigatório.',
            'neighborhood.required' => 'Bairro obrigatório.',
            'city.required' => 'Cidade obrigatória.',
            'state.required' => 'Estado obrigatório.',
            'country.required' => 'País obrigatório.',
            'zip_code.required' => 'CEP obrigatório.',
        ];
    }
}
