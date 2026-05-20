<?php

namespace App\Providers;

// category interface repository service
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

// product interface repository service
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

// customer interface repository service
use App\Interfaces\CustomerRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Services\CustomerService;

// supplier interface repository service
use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;
use App\Services\SupplierService;

// brand interface repository service
use App\Interfaces\BrandRepositoryInterface;
use App\Repositories\BrandRepository;
use App\Services\BrandService;

// purchase interface repository service
use App\Interfaces\PurchaseRepositoryInterface;
use App\Repositories\PurchaseRepository;
use App\Services\PurchaseService;


// Sale interface repository service
use App\Interfaces\SaleRepositoryInterface;
use App\Repositories\SaleRepository;
use App\Services\InventoryService;
use App\Services\SaleService;

// Report interface repository service
use App\Interfaces\ReportRepositoryInterface;
use App\Repositories\ReportRepository;
use App\Services\ReportService;

// Setting updates
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->singleton(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
        });

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->singleton(CustomerService::class, function ($app) {
            return new CustomerService($app->make(CustomerRepositoryInterface::class));
        });

        $this->app->bind(
            SupplierRepositoryInterface::class,
            SupplierRepository::class
        );

        $this->app->singleton(SupplierService::class, function ($app) {
            return new SupplierService(
                $app->make(SupplierRepositoryInterface::class)
            );
        });

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->singleton(BrandService::class, function ($app) {
            return new BrandService(
                $app->make(BrandRepositoryInterface::class)
            );
        });

        $this->app->bind(
            PurchaseRepositoryInterface::class,
            PurchaseRepository::class
        );

        $this->app->singleton(PurchaseService::class, function ($app) {
            return new PurchaseService(
                $app->make(PurchaseRepositoryInterface::class)
            );
        });

        $this->app->bind(
            SaleRepositoryInterface::class,
            SaleRepository::class
        );

        $this->app->singleton(SaleService::class, function ($app) {
            return new SaleService(
                $app->make(SaleRepositoryInterface::class),
                $app->make(InventoryService::class)
            );
        });

        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );

        $this->app->singleton(ReportService::class, function ($app) {
            return new ReportService(
                $app->make(ReportRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = Setting::first();

        if (! $setting) {
            $setting = new Setting([
                'currency' => 'PKR',
                'tax_percentage' => 0,
            ]);
        }

        View::share('setting', $setting);
    }
}
