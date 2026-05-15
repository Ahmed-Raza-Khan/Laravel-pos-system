<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SaleItem;

class DashboardController extends Controller
{
    /**
     * Dashboard
     */
    public function index()
    {
        $totalSales = Sale::sum('grand_total');
        $totalPurchases = Purchase::sum('total_amount');
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();
        $lowStockProducts = Product::where('stock','<=',5)->latest()->take(5)->get();
        $recentSales = Sale::with('customer')->latest()->take(10)->get();
        $monthlySales = Sale::selectRaw('MONTH(sale_date) as month')
            ->selectRaw('SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        $monthlyPurchases = Purchase::selectRaw('MONTH(purchase_date) as month')
            ->selectRaw('SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
        $topProducts = SaleItem::selectRaw('product_id, SUM(quantity) as total_qty')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalSales',
            'totalPurchases',
            'totalProducts',
            'totalCustomers',
            'totalSuppliers',
            'lowStockProducts',
            'recentSales',
            'monthlySales',
            'monthlyPurchases',
            'topProducts',
        ));
    }
}