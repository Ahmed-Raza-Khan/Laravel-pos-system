<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();

    public function store(array $data);

    public function findById($id);

    public function update($id, array $data);

    public function delete($id);
}