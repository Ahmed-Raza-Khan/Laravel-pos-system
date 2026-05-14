<?php

namespace App\Services;

use App\Interfaces\PurchaseRepositoryInterface;

class PurchaseService
{
    protected $repo;

    public function __construct(PurchaseRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAllPurchases()
    {
        return $this->repo->getAll();
    }

    public function createPurchase(array $data)
    {
        return $this->repo->store($data);
    }

    public function getPurchase($id)
    {
        return $this->repo->findById($id);
    }

    public function updatePurchase($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deletePurchase($id)
    {
        return $this->repo->delete($id);
    }
}