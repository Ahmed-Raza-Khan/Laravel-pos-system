<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'store_name',
        'store_address',
        'contact_email',
        'contact_phone',
        'tax_percentage',
        'currency',
        'invoice_prefix',
        'invoice_logo',
        'invoice_terms',
        'invoice_footer',
    ];
}
