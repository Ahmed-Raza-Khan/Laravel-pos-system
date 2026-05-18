<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:view dashboard'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'permission:manage categories'])->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
});

Route::middleware(['auth', 'permission:manage brands'])->group(function () {
    Route::resource('brands', BrandController::class);
});

Route::middleware(['auth', 'permission:manage products'])->group(function () {
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::get('/products/import', [ProductController::class, 'importForm'])->name('products.import');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import.store');
    Route::resource('products', ProductController::class);
    Route::get('/products/{id}/barcode', [ProductController::class, 'barcode'])->name('products.barcode');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
});

Route::middleware(['auth', 'permission:manage customers'])->group(function () {
    Route::resource('customers', CustomerController::class)->except(['show']);
});

Route::middleware(['auth', 'permission:manage suppliers'])->group(function () {
    Route::resource('suppliers', SupplierController::class)->except(['show']);
});

Route::middleware(['auth', 'permission:manage purchases'])->group(function () {
    Route::post('/purchases/{id}/approve', [PurchaseController::class, 'approve'])->name('purchases.approve');
    Route::post('/purchases/{id}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
    Route::resource('purchases', PurchaseController::class);
});

Route::middleware(['auth', 'permission:manage settings'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

Route::middleware(['auth', 'permission:manage reports'])->group(function () {
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');
        Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
        Route::get('/suppliers', [ReportController::class, 'suppliers'])->name('suppliers');
        Route::get('/suppliers/{supplier}/statement', [ReportController::class, 'supplierStatement'])->name('suppliers.statement');
    });
});

Route::middleware(['auth', 'permission:manage sales'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('index');
    Route::get('/create', [SaleController::class, 'create'])->name('create');
    Route::post('/store', [SaleController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [SaleController::class, 'edit'])->name('edit');
    Route::put('/{id}', [SaleController::class, 'update'])->name('update');
    Route::post('/{id}/void', [SaleController::class, 'void'])->name('void');
    Route::post('/{id}/payment', [SaleController::class, 'recordPayment'])->name('payment');
    Route::post('/hold-cart', [SaleController::class, 'holdCart'])->name('holdCart');
    Route::post('/resume-cart/{id}', [SaleController::class, 'resumeCart'])->name('resumeCart');
    Route::get('/show/{id}', [SaleController::class, 'show'])->name('show');
    Route::post('/add-to-cart/{id}', [SaleController::class, 'addToCart'])->name('addToCart');
    Route::post('/update-cart/{id}', [SaleController::class, 'updateCart'])->name('updateCart');
    Route::delete('/remove-cart/{id}', [SaleController::class, 'removeCart'])->name('removeCart');
    Route::delete('/clear-cart', [SaleController::class, 'clearCart'])->name('clearCart');
});

Route::middleware(['auth', 'permission:manage inventory'])->prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('index');
    Route::post('/adjust/{id}', [InventoryController::class, 'adjust'])->name('adjust');
    Route::get('/history', [InventoryController::class, 'history'])->name('history');
});

Route::middleware(['auth', 'permission:manage users'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';
