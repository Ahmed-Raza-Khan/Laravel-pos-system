<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SaleItem;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Modern POS Dashboard Analytics
     */
    public function index()
    {
        $setting = Setting::first();

        $totalSales = Sale::where('status', '!=', 'voided')->sum('grand_total');
        $totalPurchases = Purchase::sum('total_amount');
        $netProfitLoss = $totalSales - $totalPurchases;

        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalSuppliers = Supplier::count();

        $voidSalesCount = Sale::where('status', 'voided')->count();
        
        $lowStockProducts = Product::with('warehouseStocks')
            ->get()
            ->sortBy('total_stock')
            ->take(5);

        $recentSales = Sale::with('customer')
            ->where('status', '!=', 'voided')
            ->latest()
            ->take(6)
            ->get();

        $monthlySales = Sale::where('status', '!=', 'voided')
            ->selectRaw('MONTH(sale_date) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthlyPurchases = Purchase::selectRaw('MONTH(purchase_date) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $monthsMap = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        $salesData = [];
        $purchaseData = [];
        $chartLabels = [];

        foreach ($monthsMap as $num => $name) {
            if (isset($monthlySales[$num]) || isset($monthlyPurchases[$num])) {
                $chartLabels[] = $name;
                $salesData[] = $monthlySales[$num] ?? 0;
                $purchaseData[] = $monthlyPurchases[$num] ?? 0;
            }
        }

        $topProducts = SaleItem::selectRaw('product_id, SUM(quantity) as total_qty')
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'setting',
            'totalSales',
            'totalPurchases',
            'netProfitLoss',
            'totalProducts',
            'totalCustomers',
            'totalSuppliers',
            'voidSalesCount',
            'lowStockProducts',
            'recentSales',
            'chartLabels',
            'salesData',
            'purchaseData',
            'topProducts'
        ));
    }
}