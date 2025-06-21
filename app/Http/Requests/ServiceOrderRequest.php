<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceOrderRequest extends FormRequest
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
			'order_number' => ['required', 'string'],
			'client_id' => ['required', 'integer'],
			'so_device_id' => ['required', 'integer'],
			'so_status_id' => ['required', 'integer'],
			'so_status_steps_id' => ['required', 'integer'],
			'warranty_expires_on' => ['nullable'],
			'labor_cost' => ['nullable'],
			'parts_cost' => ['nullable'],
			'service_cost' => ['nullable'],
			'discount' => ['nullable'],
			'advance_payment' => ['nullable'],
			'in_use' => ['required'],
			'currently_editing' => ['nullable', 'string'],
			'initially_attended_by' => ['nullable', 'string'],
			'abandonment_alert' => ['nullable'],
			'quoted_by_technician' => ['nullable', 'string'],
			'repaired_by_technician' => ['nullable', 'string'],
			'internal_notes' => ['nullable', 'string'],
			'closed_at' => ['nullable'],
			'reopened_at' => ['nullable'],
		];
	}
}
