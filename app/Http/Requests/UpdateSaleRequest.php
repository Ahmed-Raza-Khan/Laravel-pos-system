<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manage sales');
    }

    public function rules(): array
    {
        return (new StoreSaleRequest())->rules();
    }
}
