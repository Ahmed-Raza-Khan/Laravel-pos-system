<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\Setting;
use App\Support\IndexTable;
use App\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(
            Sale::with(['customer', 'items']),
            ['invoice_no', 'customer.name', 'grand_total', 'status', 'sale_date'],
            'sale_date'
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
        $prefix = $setting && $setting->invoice_prefix ? trim($setting->invoice_prefix) : 'INV';
        $prefix = rtrim($prefix, '-') . '-';
        $date = now()->format('Ymd');

        $lastSale = Sale::whereDate('created_at', today())->where('invoice_no', 'like', $prefix . $date . '-%')->latest('id')->first();
        $number = 1;
        if ($lastSale) {
            $parts = explode('-', $lastSale->invoice_no);
            $lastNumber = (int) end($parts);
            $number = $lastNumber + 1;
        }

        return $prefix . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}