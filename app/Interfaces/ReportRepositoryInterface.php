<?php

namespace App\Interfaces;

interface ReportRepositoryInterface
{
    public function getDailySalesReport(string $date, ?string $endDate = null): array;

    public function getMonthlySalesReport(?int $year = null): array;

    public function getPurchaseReport(?string $from = null, ?string $to = null, ?int $supplierId = null): array;

    public function getStockReport(): array;

    public function getProfitLossReport(?string $from = null, ?string $to = null): array;

    public function getCustomerReport(): array;

    public function getSupplierReport(): array;
}
