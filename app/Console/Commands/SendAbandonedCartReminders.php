<?php

namespace App\Console\Commands;

use App\Mail\AbandonedCartReminder;
use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAbandonedCartReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:send-abandoned-cart-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to users with abandoned carts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for abandoned carts...');

        // Find carts updated > 24 hours ago, belonging to a user, and not yet notified
        // For demonstration, let's use 1 hour to make testing easier if needed, or stick to 24h
        $carts = Cart::where('updated_at', '<', now()->subHours(24))
            ->whereNotNull('user_id')
            ->whereNull('abandoned_cart_mail_sent_at')
            ->whereHas('items') // Make sure cart is not empty
            ->with(['user', 'items.product'])
            ->get();

        $count = $carts->count();
        $this->info("Found {$count} abandoned carts.");

        foreach ($carts as $cart) {
            try {
                if ($cart->user && $cart->user->email) {
                    Mail::to($cart->user->email)->send(new AbandonedCartReminder($cart));
                    
                    $cart->abandoned_cart_mail_sent_at = now();
                    $cart->save();

                    $this->info("Sent reminder to: " . $cart->user->email);
                }
            } catch (\Exception $e) {
                Log::error("Failed to send abandoned cart email: " . $e->getMessage());
                $this->error("Failed to send to cart ID: " . $cart->id);
            }
        }

        $this->info('Done.');
    }
}
