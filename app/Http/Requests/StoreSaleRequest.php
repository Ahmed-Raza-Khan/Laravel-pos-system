<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => ['nullable', 'exists:customers,id'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],

            'discount_type' => [
                'nullable',
                'in:fixed,percentage'
            ],
            'discount_value' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'tax_percentage' => [
                'required',
                'numeric',
                'min:0'
            ],
            'paid_amount' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999'
            ],
            'payment_method' => [
                'required',
                'in:cash,card,bank_transfer,easypaisa,jazzcash'
            ],
            'notes' => [
                'nullable',
                'string'
            ],
        ];
    }
}
