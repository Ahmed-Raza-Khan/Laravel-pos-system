<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class IndexTable
{
    public static function apply(Builder $query, array $searchable, string $defaultSort = 'created_at', int $perPage = 10): LengthAwarePaginator
    {
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
        $allowed = array_merge($searchable, ['id', 'created_at', 'updated_at', 'name', 'email', 'invoice_no', 'sale_date', 'purchase_date', 'grand_total', 'total_amount', 'stock', 'sale_price', 'purchase_price']);
        if (! in_array($sort, $allowed, true)) {
            $sort = $defaultSort;
        }

        $direction = request('direction') === 'asc' ? 'asc' : 'desc';

        return $query->orderBy($sort, $direction)->paginate(request('per_page', $perPage))->withQueryString();
    }
}
