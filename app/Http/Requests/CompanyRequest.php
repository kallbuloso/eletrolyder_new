<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'tenant_id' => ['nullable', 'exists:tenants,id'],
            'name' => ['required', 'string'],
            'fantasy_name' => ['nullable', 'string'],
            'contact_name' => ['nullable', 'string'],
            'person' => ['required', 'string'],
            'cpf_cnpj' => ['required', 'string'],
            'rg_insc_est' => ['nullable', 'string'],
            'ccm' => ['nullable', 'string'],
            'birth_date' => ['required', 'string'],
            'logo' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'website' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
        ];
    }
}
