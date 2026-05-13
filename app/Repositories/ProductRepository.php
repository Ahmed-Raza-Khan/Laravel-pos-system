<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::with('category')->latest()->paginate(10);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        return $product->update($data);
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }
}