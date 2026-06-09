<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Support\IndexTable;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(
            Product::with(['category', 'brand']),
            ['name', 'sku', 'barcode', 'category.name', 'brand.name', 'sale_price'],
            'name'
        );
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
        $product->update($data);

        return $product;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }
}