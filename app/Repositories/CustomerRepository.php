<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAll()
    {
        return Customer::latest()->paginate(5);
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