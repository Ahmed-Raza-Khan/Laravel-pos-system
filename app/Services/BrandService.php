<?php

namespace App\Services;

use App\Interfaces\BrandRepositoryInterface;

class BrandService
{
    protected $repo;

    public function __construct(BrandRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAllBrands()
    {
        return $this->repo->getAll();
    }

    public function createBrand(array $data)
    {
        return $this->repo->store($data);
    }

    public function getBrand($id)
    {
        return $this->repo->findById($id);
    }

    public function updateBrand($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteBrand($id)
    {
        return $this->repo->delete($id);
    }
}