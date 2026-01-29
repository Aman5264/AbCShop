<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\MergeGuestCart;

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
        // 🔒 Force HTTPS for all links when on Production or behind a Proxy
        if (app()->environment('production') || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }

    // Merge guest cart on login
    Event::listen(
        Login::class,
        MergeGuestCart::class
    );

    // Share Cart Count with layouts
    View::composer(
        ['components.shop-layout', 'components.navbar', 'components.account-layout', 'layouts.navigation'],
        function ($view) {
            try {
                $cartService = app(\App\Services\CartService::class);
                $view->with('cartCount', $cartService->count());
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
            }
            
            // Share Active Pages
            try {
                $pages = \App\Models\Page::published()->get(['title', 'slug']);
                $view->with('navPages', $pages);
            } catch (\Exception $e) {
                $view->with('navPages', collect());
            }

            // Share Categories
            try {
                $categories = \App\Models\Category::whereNull('parent_id')->get(['name', 'slug']);
                $view->with('shopCategories', $categories);
            } catch (\Exception $e) {
                $view->with('shopCategories', collect());
            }
        }
    );
}
}
