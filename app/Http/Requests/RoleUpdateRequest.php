<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
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
            'id' => ['required', 'exists:roles,id', 'integer'],
            'name' => ['required', 'string', 'max:100', Rule::unique('roles', 'tenant_id')->ignore($this->id)],
            'description' => ['nullable', 'string'],
            'guard_name' => ['required', 'string'],
            'permissions.*' => ['nullable', 'exists:permissions,id'],
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
            'name.unique' => 'Já existe um acesso com esse nome.',
        ];
    }
}
