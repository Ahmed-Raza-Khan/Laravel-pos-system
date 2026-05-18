<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;
use App\Support\IndexTable;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(Supplier::query(), ['name', 'company', 'phone'], 'name', 10);
    }

    public function store(array $data)
    {
        return Supplier::create($data);
    }

    public function findById($id)
    {
        return Supplier::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $supplier = Supplier::findOrFail($id);

        return $supplier->update($data);
    }

    public function delete($id)
    {
        return Supplier::destroy($id);
    }
}
