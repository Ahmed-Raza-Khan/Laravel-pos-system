<?php

namespace App\Interfaces;

interface SaleRepositoryInterface
{
    public function getAll();

    public function findById(int $id);

    public function create(array $data);

    public function generateInvoiceNumber();
}