<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Responses\LoginResponse as CustomLoginResponse;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {  
        // URL::forceScheme('https');
    }

    // public const HOME = '/dashboard';

}
