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
      'description' => ['nullable', 'string'],
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
}
