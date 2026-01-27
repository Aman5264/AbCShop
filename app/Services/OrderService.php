<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Update order status and handle side effects (inventory, emails).
     */
    public function updateOrderStatus(Order $order, string $newStatus, ?string $notes = null, ?User $user = null): Order
    {
        if ($order->status === $newStatus) {
            return $order;
        }

        $oldStatus = $order->status;

        DB::transaction(function () use ($order, $newStatus, $notes, $oldStatus, $user) {
            $order->update([
                'status' => $newStatus,
                'notes' => $notes ? $order->notes . "\n" . $notes : $order->notes,
            ]);

            // Handle Inventory Logic for cancellations/refunds
            if (in_array($newStatus, ['cancelled', 'refunded']) && !in_array($oldStatus, ['cancelled', 'refunded'])) {
                // Restore stock for all items
                // Assuming Order has many OrderItems (implementation pending in Order model, using placeholder logic)
                foreach ($order->items as $item) {
                    $this->inventoryService->incrementStock($item->product, $item->quantity, "Order #{$order->id} {$newStatus}", $user);
                }
                Log::info("Order #{$order->id} cancelled. Stock restoration logic triggered.");
            }
        });

        // Trigger Events (e.g., OrderStatusUpdated)
        // OrderStatusUpdated::dispatch($order);

        return $order;
    }
}
