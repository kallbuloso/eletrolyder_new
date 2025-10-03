<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,tenant_id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo_path' => ['string', 'nullable'],
            'roles.*' => ['required', 'exists:roles,id'],
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
            'name.required' => 'Nome do usuário é obrigatório.',
            'email.unique' => 'Já existe um usuário com esse email.',
            'password.required' => 'Senha do usuário é obrigatória.',
            'roles.required' => 'Selecione um tipo de acesso.',
        ];
    }
}
