<?php

namespace App\Repositories;

use App\Interfaces\ReportRepositoryInterface;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function getDailySalesReport(string $date, ?string $endDate = null): array
    {
        $query = Sale::query();

        if ($endDate) {
            $query->whereBetween('sale_date', [$date, $endDate]);
        } else {
            $query->whereDate('sale_date', $date);
        }

        $sales = (clone $query)->get();

        $paymentMethods = (clone $query)
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(grand_total) as total'))
            ->groupBy('payment_method')
            ->get();

        $profit = $this->calculateProfitForSales((clone $query)->pluck('id'));

        return [
            'date' => $date,
            'end_date' => $endDate,
            'total_sales' => $sales->sum('grand_total'),
            'invoice_count' => $sales->count(),
            'payment_methods' => $paymentMethods,
            'profit' => $profit,
            'taxes' => $sales->sum('tax_amount'),
            'discounts' => $sales->sum('discount_amount'),
            'invoices' => (clone $query)
                ->with('customer')
                ->orderByDesc('sale_date')
                ->orderByDesc('id')
                ->get(),
        ];
    }

    public function getMonthlySalesReport(?int $year = null, ?int $month = null): array
    {
        $year = $year ?? (int) now()->year;

        $monthlySales = Sale::query()
            ->whereYear('sale_date', $year)
            ->selectRaw('MONTH(sale_date) as month')
            ->selectRaw('SUM(grand_total) as total')
            ->selectRaw('COUNT(*) as invoices')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenue = $monthlySales->sum('total');

        $bestSellingProducts = SaleItem::query()
            ->select('sale_items.product_id', DB::raw('SUM(sale_items.quantity) as total_qty'), DB::raw('SUM(sale_items.total) as revenue'))
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->whereYear('sales.sale_date', $year)
            ->groupBy('sale_items.product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(10)
            ->get();

        $monthNames = collect(range(1, 12))->mapWithKeys(function ($monthNumber) use ($monthlySales) {
            $row = $monthlySales->firstWhere('month', $monthNumber);

            return [$monthNumber => [
                'label' => Carbon::create()->month($monthNumber)->format('M'),
                'total' => (float) ($row->total ?? 0),
                'invoices' => (int) ($row->invoices ?? 0),
            ]];
        });

        $selectedMonth = null;
        $selectedMonthTotal = null;
        $selectedMonthInvoices = null;

        if ($month && $month >= 1 && $month <= 12) {
            $selectedMonth = Carbon::create()->month($month)->format('F');
            $selectedRow = $monthlySales->firstWhere('month', $month);
            $selectedMonthTotal = (float) ($selectedRow->total ?? 0);
            $selectedMonthInvoices = (int) ($selectedRow->invoices ?? 0);
        }

        return [
            'year' => $year,
            'monthly_sales' => $monthlySales,
            'month_names' => $monthNames,
            'monthly_revenue' => $monthlyRevenue,
            'best_selling_products' => $bestSellingProducts,
            'selected_month' => $selectedMonth,
            'selected_month_total' => $selectedMonthTotal,
            'selected_month_invoices' => $selectedMonthInvoices,
            'selected_month_number' => $month,
        ];
    }

    public function getPurchaseReport(?string $from = null, ?string $to = null, ?int $supplierId = null): array
    {
        $query = Purchase::with(['supplier', 'items.product']);

        if ($from && $to) {
            $query->whereBetween('purchase_date', [$from, $to]);
        } elseif ($from) {
            $query->whereDate('purchase_date', '>=', $from);
        } elseif ($to) {
            $query->whereDate('purchase_date', '<=', $to);
        }

        if ($supplierId) {
            $query->where('supplier_id', $supplierId);
        }

        $statsQuery = clone $query;
        $allPurchases = $statsQuery->get();

        $totalStock = $allPurchases->sum(function ($purchase) {
            return $purchase->items->sum('quantity');
        });

        $totalPurchaseAmount = $allPurchases->sum('total_amount');

        $purchases = $query->orderByDesc('purchase_date')->paginate(10)->withQueryString();

        return [
            'purchases' => $purchases,
            'total_purchased_stock' => $totalStock,
            'total_purchase_amount' => $totalPurchaseAmount,
            'from' => $from,
            'to' => $to,
            'supplier_id' => $supplierId,
            'suppliers' => Supplier::orderBy('name')->get(),
        ];
    }

    public function getStockReport(): array
    {
        $productQuery = Product::query();

        $products = $productQuery->with(['category', 'brand'])
            ->orderBy('name')
            ->paginate(10);

        $lowStockThreshold = 5;

        $allProducts = Product::query()->get();

        return [
            'products' => $products,
            'current_stock_count' => $allProducts->sum('stock'),
            'low_stock' => $allProducts->where('stock', '>', 0)->where('stock', '<=', $lowStockThreshold)->values(),
            'out_of_stock' => $allProducts->where('stock', '<=', 0)->values(),
            'in_stock' => $allProducts->where('stock', '>', $lowStockThreshold)->values(),
            'inventory_valuation' => $allProducts->sum(fn ($p) => $p->stock * $p->purchase_price),
            'low_stock_threshold' => $lowStockThreshold,
        ];
    }

    public function getProfitLossReport(?string $from = null, ?string $to = null): array
    {
        $itemsQuery = SaleItem::query()
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id');

        if ($from && $to) {
            $itemsQuery->whereBetween('sales.sale_date', [$from, $to]);
        } elseif ($from) {
            $itemsQuery->whereDate('sales.sale_date', '>=', $from);
        } elseif ($to) {
            $itemsQuery->whereDate('sales.sale_date', '<=', $to);
        }

        $totals = (clone $itemsQuery)
            ->selectRaw('SUM(sale_items.total) as revenue')
            ->selectRaw('SUM(sale_items.quantity * products.purchase_price) as cost')
            ->selectRaw('SUM(sale_items.quantity) as sold_qty')
            ->first();

        $revenue = (float) ($totals->revenue ?? 0);
        $cost = (float) ($totals->cost ?? 0);
        $profit = $revenue - $cost;

        $productBreakdown = (clone $itemsQuery)
            ->select(
                'sale_items.product_id',
                DB::raw('SUM(sale_items.quantity) as sold_qty'),
                DB::raw('SUM(sale_items.total) as revenue'),
                DB::raw('SUM(sale_items.quantity * products.purchase_price) as cost')
            )
            ->groupBy('sale_items.product_id')
            ->orderByRaw('SUM(sale_items.total) - SUM(sale_items.quantity * products.purchase_price) DESC')
            ->with('product')
            ->take(20)
            ->get()
            ->map(function ($row) {
                $row->profit = $row->revenue - $row->cost;

                return $row;
            });

        return [
            'revenue' => $revenue,
            'cost' => $cost,
            'profit' => $profit,
            'sold_qty' => (int) ($totals->sold_qty ?? 0),
            'product_breakdown' => $productBreakdown,
            'from' => $from,
            'to' => $to,
        ];
    }

    public function getCustomerReport(): array
    {
        $topCustomers = Customer::query()
            ->withCount('sales')
            ->withSum('sales as total_purchases', 'grand_total')
            ->withSum('sales as total_due', 'due_amount')
            ->orderByDesc('total_purchases')
            ->take(10)
            ->get();

        $recentOrders = Sale::with('customer')
            ->orderByDesc('sale_date')
            ->orderByDesc('id')
            ->take(15)
            ->get();

        $summary = [
            'total_customers' => Customer::count(),
            'total_sales_amount' => Sale::sum('grand_total'),
            'total_due_amount' => Sale::sum('due_amount'),
        ];

        $customers = Customer::query()
            ->withCount('sales')
            ->withSum('sales as total_purchases', 'grand_total')
            ->withSum('sales as total_due', 'due_amount')
            ->orderBy('name')
            ->get();

        return [
            'summary' => $summary,
            'top_customers' => $topCustomers,
            'recent_orders' => $recentOrders,
            'customers' => $customers,
        ];
    }

    public function getSupplierReport(): array
    {
        $suppliers = Supplier::query()
            ->withCount('purchases')
            ->withSum('purchases as total_purchase_amount', 'total_amount')
            ->with(['purchases' => function ($query) {
                $query->with('items')->latest('purchase_date')->take(5);
            }])
            ->orderByDesc('total_purchase_amount')
            ->get()
            ->map(function ($supplier) {
                $supplier->total_supplied_products = PurchaseItem::query()
                    ->join('purchases', 'purchases.id', '=', 'purchase_items.purchase_id')
                    ->where('purchases.supplier_id', $supplier->id)
                    ->sum('purchase_items.quantity');

                return $supplier;
            });

        $purchaseHistory = Purchase::with(['supplier', 'items.product'])
            ->orderByDesc('purchase_date')
            ->take(20)
            ->get();

        return [
            'suppliers' => $suppliers,
            'purchase_history' => $purchaseHistory,
            'total_purchase_amount' => Purchase::sum('total_amount'),
            'total_suppliers' => Supplier::count(),
        ];
    }

    protected function calculateProfitForSales($saleIds): float
    {
        if ($saleIds->isEmpty()) {
            return 0;
        }

        $row = SaleItem::query()
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->whereIn('sale_items.sale_id', $saleIds)
            ->selectRaw('SUM(sale_items.total) as revenue')
            ->selectRaw('SUM(sale_items.quantity * products.purchase_price) as cost')
            ->first();

        return (float) ($row->revenue ?? 0) - (float) ($row->cost ?? 0);
    }
}
