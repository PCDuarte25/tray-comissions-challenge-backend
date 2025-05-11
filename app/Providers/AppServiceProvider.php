<?php

namespace App\Providers;

use App\Repositories\ConfigurationRepository;
use App\Repositories\ConfigurationRepositoryInterface;
use App\Repositories\SaleRepository;
use App\Repositories\SaleRepositoryInterface;
use App\Repositories\SellerRepository;
use App\Repositories\SellerRepositoryInterface;
use App\Services\ReportService;
use App\Services\ReportServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SellerRepositoryInterface::class, SellerRepository::class);

        $this->app->singleton(SaleRepositoryInterface::class, SaleRepository::class);

        $this->app->singleton(ConfigurationRepositoryInterface::class, ConfigurationRepository::class);

        $this->app->singleton(ReportServiceInterface::class, ReportService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
