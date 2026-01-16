<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Otorga todos los permisos implícitamente al rol 'Administrador'
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Administrador') ? true : null;
        });
    }
}
