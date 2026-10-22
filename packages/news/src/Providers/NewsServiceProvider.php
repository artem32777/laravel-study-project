<?php

namespace LaraN\News\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(PlatformServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'news');

        Route::middleware('web')->group(function (): void {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });

        Route::middleware('api')
            ->prefix('api/v1')
            ->name('api.v1.')
            ->group(function (): void {
                $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
            });
    }
}
