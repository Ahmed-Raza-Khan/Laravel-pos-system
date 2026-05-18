<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecordSalePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage sales');
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', Rule::in(['cash', 'card', 'bank_transfer', 'easypaisa', 'jazzcash'])],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }
}
