<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Support\IndexTable;
use App\Interfaces\BrandRepositoryInterface;

class BrandRepository implements BrandRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(Brand::query(), ['name', 'slug'], 'name');
    }

    public function store(array $data)
    {
        return Brand::create($data);
    }

    public function findById($id)
    {
        return Brand::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $brand = Brand::findOrFail($id);

        return $brand->update($data);
    }

    public function delete($id)
    {
        return Brand::destroy($id);
    }
}