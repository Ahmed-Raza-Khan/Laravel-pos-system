<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'store_name' => ['nullable', 'string', 'max:255'],
            'store_address' => ['nullable', 'string', 'max:1024'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'tax_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'currency' => ['required', 'string', 'max:10'],
            'invoice_prefix' => ['nullable', 'string', 'max:20'],
            'invoice_logo' => ['nullable', 'image', 'max:2048'],
            'invoice_terms' => ['nullable', 'string', 'max:2048'],
            'invoice_footer' => ['nullable', 'string', 'max:2048'],
        ];
    }
}
