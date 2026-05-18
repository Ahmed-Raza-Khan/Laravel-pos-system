<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HoldCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage sales');
    }

    public function rules(): array
    {
        return [
            'reference' => ['nullable', 'string', 'max:100'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'discount_type' => ['nullable', 'in:fixed,percentage'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
