<?php

namespace App\Interfaces;

interface WarehouseRepositoryInterface
{
    public function getAll();

    public function store(array $data);

    public function findById($id);

    public function update($id, array $data);

    public function delete($id);
}