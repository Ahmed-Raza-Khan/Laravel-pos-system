<?php

namespace App\Http\Controllers;

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
            $monthly = $this->reportService->monthlySalesReport($year);
        } else {
            $date = $request->get('date', now()->toDateString());
            $endDate = $request->get('end_date');

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
        $data = $this->reportService->purchaseReport(
            $request->get('from'),
            $request->get('to'),
            $request->integer('supplier_id') ?: null
        );

        return view('reports.purchases', $data);
    }

    public function stock()
    {
        $data = $this->reportService->stockReport();

        return view('reports.stock', $data);
    }

    public function profitLoss(Request $request)
    {
        $data = $this->reportService->profitLossReport(
            $request->get('from'),
            $request->get('to')
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
}
