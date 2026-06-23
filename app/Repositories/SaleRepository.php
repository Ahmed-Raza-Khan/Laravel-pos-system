<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\Setting;
use App\Support\IndexTable;
use App\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAll()
    {
        $perPage = (int) request('per_page', 10);
        if ($perPage < 1) {
            $perPage = 10;
        }

        return IndexTable::apply(
            // Sale::with(['customer', 'items']),
            Sale::with(['customer','warehouse']),
            ['invoice_no', 'customer.name', 'grand_total', 'status', 'sale_date'],
            'sale_date',
            $perPage
        );
    }

    public function findById(int $id)
    {
        return Sale::with(['customer','items.product','user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Sale::create($data);
    }

    public function generateInvoiceNumber(): string
    {
        $setting = Setting::first();

        $prefix = $setting?->invoice_prefix ?: 'INV';
        $prefix = rtrim($prefix, '-') . '-';

        $date = now()->format('Ymd');
        $base = $prefix . $date . '-';

        return DB::transaction(function () use ($base) {

            $last = Sale::where('invoice_no', 'like', $base . '%')
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            $next = 1;

            if ($last) {
                $parts = explode('-', $last->invoice_no);
                $next = ((int) end($parts)) + 1;
            }

            return $base . str_pad($next, 4, '0', STR_PAD_LEFT);
        });
    }
}