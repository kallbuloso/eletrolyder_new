<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
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
            'phone_type' => ['required', 'string'],
            'phone_number' => [
                'required',
                Rule::unique('phones', 'phoneable_type')->ignore($this->id)->where(function ($query) {
                    return $query->where('phoneable_id', $this->phoneable_id);
                }),
            ],
            'phone_contact' => ['nullable', 'required_if:phone_type,C', 'string'],
            'phone_has_whatsapp' => ['required', 'boolean'],
        ];
    }
}
