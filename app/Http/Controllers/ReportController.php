<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $tab = $request->get('tab', 'daily');
        $year = $request->integer('year') ?: (int) now()->year;

        $daily = null;
        $monthly = null;

        if ($tab === 'monthly') {
            $year = $request->integer('year') ?: (int) now()->year;
            $month = $request->integer('month') ?: null;

            $monthly = $this->reportService->monthlySalesReport($year, $month);
        } else {
            $validated = $request->validate([
                'date' => ['nullable', 'date', 'before_or_equal:today'],
                'end_date' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:date'],
            ]);

            $date = $validated['date'] ?? now()->toDateString();
            $endDate = $validated['end_date'] ?? null;

            if ($request->boolean('today')) {
                $date = now()->toDateString();
                $endDate = null;
            }

            $daily = $this->reportService->dailySalesReport($date, $endDate);
        }

        return view('reports.sales', compact('tab', 'year', 'daily', 'monthly'));
    }

    public function purchases(Request $request)
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date', 'before_or_equal:today'],
            'to' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:from'],
            'supplier_id' => ['nullable', 'integer', 'exists:suppliers,id'],
        ]);

        $data = $this->reportService->purchaseReport(
            $validated['from'] ?? null,
            $validated['to'] ?? null,
            $validated['supplier_id'] ?? null
        );

        return view('reports.purchases', $data);
    }

    public function stock()
    {
        $data = $this->reportService->total_stockReport();

        return view('reports.stock', $data);
    }

    public function profitLoss(Request $request)
    {
        $validated = $request->validate([
            'from' => ['nullable', 'date', 'before_or_equal:today'],
            'to' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:from'],
        ]);

        $data = $this->reportService->profitLossReport(
            $validated['from'] ?? null,
            $validated['to'] ?? null
        );

        return view('reports.profit-loss', $data);
    }

    public function customers()
    {
        $data = $this->reportService->customerReport();

        return view('reports.customers', $data);
    }

    public function suppliers()
    {
        $data = $this->reportService->supplierReport();

        return view('reports.suppliers', $data);
    }

    public function supplierStatement(Supplier $supplier)
    {
        $purchases = Purchase::with(['items.product'])
            ->where('supplier_id', $supplier->id)
            ->orderByDesc('purchase_date')
            ->get();

        $totals = [
            'count' => $purchases->count(),
            'approved' => $purchases->where('status', 'approved')->sum('total_amount'),
            'pending' => $purchases->where('status', 'pending')->sum('total_amount'),
            'items' => $purchases->sum(fn ($p) => $p->items->sum('quantity')),
        ];

        return view('reports.supplier-statement', compact('supplier', 'purchases', 'totals'));
    }
}
