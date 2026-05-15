<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Interfaces\SaleRepositoryInterface;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAll()
    {
        return Sale::with(['customer', 'items'])->latest()->paginate(10);
    }

    public function findById(int $id)
    {
        return Sale::with(['customer','items.product','user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Sale::create($data);
    }

    public function generateInvoiceNumber()
    {
        $lastSale = Sale::latest()->first();

        $number = $lastSale
            ? $lastSale->id + 1
            : 1;

        return 'INV-' . date('Ymd') . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}