<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'fantasy_name' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
            'person' => ['required'],
            'cpf_cnpj' => [
                'nullable',
                'string',
                Rule::unique('suppliers')->ignore($this->id)->where(function ($query) {
                    return $query->whereNotNull('cpf_cnpj');
                }),
                'required_if:person,J',
            ],
            'rg_ie' => ['nullable', 'string'],
            'ccm_im' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date', 'date_format:d/m/Y'],
            'logo' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'url'],
            'note' => ['nullable', 'string'],

            'phones.*.phone_type' => ['required', 'string'],
            'phones.*.phone_number' => ['required', 'string'],
            'phones.*.phone_has_whatsapp' => ['required', 'boolean'],
            'phones.*.phone_contact' => ['nullable', 'required_if:phones.*.phone_type,C'],
            // Endereço
            'addresses.*.type' => ['required', 'string'],
            'addresses.*.street' => ['required', 'string'],
            'addresses.*.number' => ['required', 'string'],
            'addresses.*.complement' => ['nullable', 'string'],
            'addresses.*.neighborhood' => ['required', 'string'],
            'addresses.*.city' => ['required', 'string'],
            'addresses.*.state' => ['required', 'string'],
            'addresses.*.country' => ['required', 'string'],
            'addresses.*.zip_code' => ['required', 'string'],
            'addresses.*.reference' => ['nullable', 'string'],
        ];
    }
}
