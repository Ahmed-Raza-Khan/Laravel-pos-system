<?php

namespace App\Repositories;

use App\Interfaces\SupplierRepositoryInterface;
use App\Models\Supplier;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAll()
    {
        return Supplier::latest()->paginate(5);
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
