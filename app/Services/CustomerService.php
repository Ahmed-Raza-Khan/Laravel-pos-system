<?php

namespace App\Services;

use App\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    protected $repo;

    public function __construct(CustomerRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAllCustomers()
    {
        return $this->repo->getAll();
    }

    public function createCustomer(array $data)
    {
        return $this->repo->store($data);
    }

    public function getCustomer($id)
    {
        return $this->repo->findById($id);
    }

    public function updateCustomer($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteCustomer($id)
    {
        return $this->repo->delete($id);
    }
}