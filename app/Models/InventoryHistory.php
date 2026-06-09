<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'notes',
        'created_by',
    ];

    /**
     * Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
