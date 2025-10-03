<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'], // 'unique:roles,tenant_id' é o mesmo que 'unique:roles,tenant_id,NULL,id'
            'description' => 'nullable|string',
            'guard_name' => 'required|string',
            'permissions.*' => 'nullable|exists:permissions,id',
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
            'name.required' => 'Nome do acesso é obrigatório.',
            // 'name.unique' => 'Já existe um acesso com esse nome.',
        ];
    }
}
