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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('purchases', PurchaseController::class);
});

Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/', [SaleController::class, 'index'])->name('index');
    Route::get('/create', [SaleController::class, 'create'])->name('create');
    Route::post('/store', [SaleController::class, 'store'])->name('store');
    Route::get('/show/{id}', [SaleController::class, 'show'])->name('show');
    Route::post('/add-to-cart/{id}', [SaleController::class, 'addToCart'])->name('addToCart');
    Route::post('/update-cart/{id}', [SaleController::class, 'updateCart'])->name('updateCart');
    Route::delete('/remove-cart/{id}', [SaleController::class, 'removeCart'])->name('removeCart');
    Route::delete('/clear-cart', [SaleController::class, 'clearCart'])->name('clearCart');
});

Route::prefix('inventory')->name('inventory.')->group(function () {
    Route::get('/',[InventoryController::class, 'index'])->name('index');
    Route::post('/adjust/{id}',[InventoryController::class, 'adjust'])->name('adjust');
    Route::get('/history',[InventoryController::class, 'history'])->name('history');
});

require __DIR__.'/auth.php';
