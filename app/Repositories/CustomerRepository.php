<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Support\IndexTable;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll()
    {
        return IndexTable::apply(Customer::query(), ['name', 'email', 'phone'], 'name', 10);
    }

    public function store(array $data)
    {
        return Customer::create($data);
    }

    public function findById($id)
    {
        return Customer::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $customer = Customer::findOrFail($id);
        return $customer->update($data);
    }

    public function delete($id)
    {
        return Customer::destroy($id);
    }
}