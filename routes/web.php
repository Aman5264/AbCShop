<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() { return view('welcome'); })->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart.index');
Route::get('/add-to-cart/{id}', [ShopController::class, 'addToCart'])->name('add.to.cart');
Route::get('/product/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/api/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('api.autocomplete');
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::post('/newsletter-subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/api/chat', \App\Http\Controllers\ChatController::class)->name('api.chat');
Route::get('/api/chat', function() { return redirect('/'); });

// FAQ Routes
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');
Route::post('/faq/{faq}/increment-views', [\App\Http\Controllers\FaqController::class, 'incrementViews'])->name('faq.increment');

// Auth Routes (Login, Register, etc.)
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::post('/stripe/webhook', [\App\Http\Controllers\WebhookController::class, 'handleStripe'])->name('stripe.webhook');

// Order Tracking (Public - No Auth Required)
Route::get('/track-order', [\App\Http\Controllers\OrderTrackingController::class, 'showForm'])->name('track.order.form');
Route::post('/track-order', [\App\Http\Controllers\OrderTrackingController::class, 'track'])->name('track.order');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{order}/refund', [\App\Http\Controllers\RefundController::class, 'store'])->name('refund.store');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Address Book
    Route::resource('addresses', \App\Http\Controllers\AddressController::class);

    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{id}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    // Reviews
    Route::post('/product/{id}/review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    


    // Checkout & Payment
    Route::middleware(['throttle:60,1'])->group(function () {
        Route::get('/checkout', [PaymentController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [PaymentController::class, 'process'])->name('checkout.process');
        Route::get('/payment/dummy/{payment}', [PaymentController::class, 'dummyShow'])->name('payment.dummy.show');
        Route::post('/payment/dummy/{payment}', [PaymentController::class, 'dummyProcess'])->name('payment.dummy.process');
        Route::post('/payment/razorpay/verify', [PaymentController::class, 'razorpayVerify'])->name('payment.razorpay.verify');
    });

    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::post('/blog/{slug}/comment', [\App\Http\Controllers\BlogController::class, 'comment'])->name('blog.comment');
});

// Catch-all must be LAST
Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
