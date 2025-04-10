<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'nick_name' => ['nullable', 'string'],
            'contact' => ['nullable', 'string'],
            'person' => ['required'],
            'cpf_cnpj' => [
                'nullable',
                'string',
                Rule::unique('suppliers')->ignore($this->id)->where(function ($query) {
                    return $query->whereNotNull('cpf_cnpj');
                }),
                'required_if:person,J'
            ],
            'birth_date' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'status' => ['required'],
            'blocking_reason' => ['nullable', 'string', 'required_if:status,B'],
            'last_purchase' => ['nullable', 'string'],

            'phones.*.phone_type' => ['required', 'string'],
            'phones.*.phone_number' => ['required', 'string'],
            'phones.*.phone_has_whatsapp' => ['required', 'boolean'],
            'phones.*.phone_contact' => ['nullable', 'required_if:phones.*.phone_type,C'],
            // Site e E-mail
            'site' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Seu fornecedor precisa de um nome.',
            'cpf_cnpj.required_if' => 'Obrigatório para PJ.',
            'cpf_cnpj.unique' => 'Documento já cadastrado.',
            'blocking_reason.required_if' => 'O motivo do bloqueio é obrigatório.',
            'phones.*.phone_number.required' => 'Telefone é obrigatório.',
            'phones.*.phone_contact.required_if' => 'Contato é obrigatório.',
        ];
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'email',
        ];
    }
}
