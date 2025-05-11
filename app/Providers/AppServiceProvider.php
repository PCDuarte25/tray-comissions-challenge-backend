<?php

namespace App\Providers;

use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('SellerRepositoryInterface', function ($app) {
            return new SellerRepository;
        });

        $this->app->singleton('SaleRepositoryInterface', function ($app) {
            return new SaleRepository;
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
