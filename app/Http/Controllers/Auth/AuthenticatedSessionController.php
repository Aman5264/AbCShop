<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Migrate session cart to database
        $sessionCart = session('cart', []);
        if(count($sessionCart) > 0) {
            foreach($sessionCart as $id => $details) {
                $cartItem = \App\Models\CartItem::where('user_id', \Illuminate\Support\Facades\Auth::id())
                    ->where('product_id', $id)->first();
                
                if($cartItem) {
                    $cartItem->increment('quantity', $details['quantity']);
                } else {
                    \App\Models\CartItem::create([
                        'user_id' => \Illuminate\Support\Facades\Auth::id(),
                        'product_id' => $id,
                        'quantity' => $details['quantity'],
                    ]);
                }
            }
            session()->forget('cart');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
