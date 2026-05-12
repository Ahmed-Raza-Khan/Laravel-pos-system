<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
