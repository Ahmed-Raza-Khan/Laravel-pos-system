<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeldCart extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'cart_data',
        'customer_id',
        'checkout_meta',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'checkout_meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
