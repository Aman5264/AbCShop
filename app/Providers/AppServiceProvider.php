<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\MergeGuestCart::class
        );

        // Share Cart Count with main shop layouts only (prevents redundant queries on every partial)
        \Illuminate\Support\Facades\View::composer(['components.shop-layout', 'components.navbar', 'components.account-layout'], function ($view) {
            $cartService = app(\App\Services\CartService::class);
            $view->with('cartCount', $cartService->count());
        });
    }
}
