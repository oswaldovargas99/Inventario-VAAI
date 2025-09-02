<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Inventarios\Dependencia;
use App\Models\Inventarios\Movimiento;
use App\Observers\MovimientoObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Comparte dependencias con la vista de registro
        View::composer('auth.register', function ($view) {$view->with('dependencias', Dependencia::orderBy('nombre')->get(['id','nombre','siglas']));});
        Movimiento::observe(MovimientoObserver::class);
    }
}
