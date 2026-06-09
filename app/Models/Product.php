<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'purchase_price',
        'sale_price',
        // 'stock',
        'image',
        'description',
        'status'
    ];

    protected $appends = [
        'total_stock'
    ];

    public function getTotalStockAttribute()
    {
        return $this->relationLoaded('warehouseStocks')
            ? $this->warehouseStocks->sum('stock')
            : $this->warehouseStocks()->sum('stock');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function inventoryHistories()
    {
        return $this->hasMany(InventoryHistory::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class,'warehouse_products')->withPivot('stock');
    }

    public function warehouseStocks()
    {
        return $this->hasMany(WarehouseProduct::class);
    }
}