<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use App\Support\IndexTable;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(Supplier::with('warehouses'), ['name', 'company', 'phone'], 'name', 10);
    }

    public function store(array $data)
    {
        $supplier = Supplier::create($data);
        $supplier->warehouses()->sync(
            $data['warehouses'] ?? []
        );

        return $supplier;
    }

    public function findById($id)
    {
        return Supplier::with('warehouses')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        $supplier->warehouses()->sync(
            $data['warehouses'] ?? []
        );

        return $supplier;
    }

    public function delete($id)
    {
        return Supplier::destroy($id);
    }
}
