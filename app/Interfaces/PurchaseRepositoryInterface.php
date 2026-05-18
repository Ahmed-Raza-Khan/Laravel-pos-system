<?php

namespace App\Interfaces;

interface PurchaseRepositoryInterface
{
    public function getAll();

    public function store(array $data);

    public function findById($id);

    public function update($id, array $data);

    public function delete($id);

    public function approve(int $id);

    public function cancel(int $id);
}