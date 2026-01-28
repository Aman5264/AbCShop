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
    // ✅ Force HTTPS in production (Fixes Mixed Content on Railway)
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }

    // Merge guest cart on login
    Event::listen(
        Login::class,
        MergeGuestCart::class
    );

    // Share Cart Count with layouts
    View::composer(
        ['components.shop-layout', 'components.navbar', 'components.account-layout'],
        function ($view) {
            $cartService = app(\App\Services\CartService::class);
            $view->with('cartCount', $cartService->count());
        }
    );
}
}
