<?php

namespace App\Repositories;

use App\Models\Warehouse;
use App\Support\IndexTable;
use App\Interfaces\WarehouseRepositoryInterface;

class WarehouseRepository implements WarehouseRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(
            Warehouse::query(),
            ['name', 'code', 'phone'],
            'name',
            10
        );
    }

    public function store(array $data)
    {
        return Warehouse::create($data);
    }

    public function findById($id)
    {
        return Warehouse::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $warehouse = Warehouse::findOrFail($id);

        return $warehouse->update($data);
    }

    public function delete($id)
    {
        return Warehouse::destroy($id);
    }
}