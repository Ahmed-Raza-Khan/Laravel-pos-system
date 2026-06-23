<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexTable
{
    public static function apply(Builder $query, array $searchable, string $defaultSort = 'created_at', $perPage = 10): LengthAwarePaginator
    {
        // Search handling
        if ($search = request('search')) {
            $query->where(function (Builder $q) use ($search, $searchable) {
                foreach ($searchable as $column) {
                    if (str_contains($column, '.')) {
                        [$relation, $field] = explode('.', $column, 2);
                        $q->orWhereHas($relation, fn (Builder $rel) => $rel->where($field, 'like', "%{$search}%"));
                    } else {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                }
            });
        }

        $sort = request('sort', $defaultSort);
        
        // FIX: Map 'stock' to 'total_stock' for products
        $model = $query->getModel();
        if ($sort === 'stock' && $model instanceof \App\Models\Product) {
            $sort = 'total_stock';
        }
        
        $allowed = array_merge($searchable, ['id', 'created_at', 'updated_at', 'name', 'email', 'invoice_no', 'sale_date', 'purchase_date', 'grand_total', 'total_amount', 'stock', 'sale_price', 'purchase_price', 'total_stock']);
        if (! in_array($sort, $allowed, true)) {
            $sort = $defaultSort;
        }

        $direction = request('direction') === 'asc' ? 'asc' : 'desc';
        
        // FIX: Cast per_page to integer
        $perPage = (int) request('per_page', $perPage);
        if ($perPage < 1) {
            $perPage = 10;
        }

        // Handle sorting by total_stock (virtual attribute)
        if ($sort === 'total_stock' && $model instanceof \App\Models\Product) {
            return $query->withSum('warehouseStocks', 'stock')
                ->orderBy('warehouse_stocks_sum_stock', $direction)
                ->paginate($perPage)
                ->withQueryString();
        }

        return $query->orderBy($sort, $direction)->paginate($perPage)->withQueryString();
    }
}