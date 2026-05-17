<?php

namespace App\Services;

use App\Interfaces\ReportRepositoryInterface;

class ReportService
{
    protected $repo;

    public function __construct(ReportRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function dailySalesReport(?string $date = null, ?string $endDate = null): array
    {
        $date = $date ?? now()->toDateString();

        return $this->repo->getDailySalesReport($date, $endDate);
    }

    public function monthlySalesReport(?int $year = null): array
    {
        return $this->repo->getMonthlySalesReport($year);
    }

    public function purchaseReport(?string $from = null, ?string $to = null, ?int $supplierId = null): array
    {
        return $this->repo->getPurchaseReport($from, $to, $supplierId);
    }

    public function stockReport(): array
    {
        return $this->repo->getStockReport();
    }

    public function profitLossReport(?string $from = null, ?string $to = null): array
    {
        return $this->repo->getProfitLossReport($from, $to);
    }

    public function customerReport(): array
    {
        return $this->repo->getCustomerReport();
    }

    public function supplierReport(): array
    {
        return $this->repo->getSupplierReport();
    }
}
