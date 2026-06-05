<?php

namespace App\Services;

use App\Interfaces\WarehouseRepositoryInterface;

class WarehouseService
{
    protected $warehouseRepository;

    public function __construct(
        WarehouseRepositoryInterface $warehouseRepository
    ) {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function getAllWarehouses()
    {
        return $this->warehouseRepository->getAll();
    }

    public function createWarehouse(array $data)
    {
        return $this->warehouseRepository->store($data);
    }

    public function getWarehouse($id)
    {
        return $this->warehouseRepository->findById($id);
    }

    public function updateWarehouse($id, array $data)
    {
        return $this->warehouseRepository->update($id, $data);
    }

    public function deleteWarehouse($id)
    {
        return $this->warehouseRepository->delete($id);
    }
}