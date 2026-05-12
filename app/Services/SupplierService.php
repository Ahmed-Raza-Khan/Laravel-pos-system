<?php

namespace App\Services;

use App\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * Get all suppliers
     */
    public function getAllSuppliers()
    {
        return $this->supplierRepository->getAll();
    }

    /**
     * Create supplier
     */
    public function createSupplier(array $data)
    {
        return $this->supplierRepository->store($data);
    }

    /**
     * Get single supplier
     */
    public function getSupplier($id)
    {
        return $this->supplierRepository->findById($id);
    }

    /**
     * Update supplier
     */
    public function updateSupplier($id, array $data)
    {
        return $this->supplierRepository->update($id, $data);
    }

    /**
     * Delete supplier
     */
    public function deleteSupplier($id)
    {
        return $this->supplierRepository->delete($id);
    }
}