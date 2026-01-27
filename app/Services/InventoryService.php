<?php

namespace App\Services;

use App\Models\Product;
use App\Models\InventoryLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    /**
     * Check if product has sufficient stock.
     */
    public function checkStock(Product $product, int $quantity): bool
    {
        return $product->stock >= $quantity;
    }

    /**
     * Decrement stock for a product.
     *
     * @throws Exception
     */
    public function decrementStock(Product $product, int $quantity, string $reason, ?User $user = null): void
    {
        if (!$this->checkStock($product, $quantity)) {
            throw new Exception("Insufficient stock for product: {$product->name}");
        }

        DB::transaction(function () use ($product, $quantity, $reason, $user) {
            $previousStock = $product->stock;
            
            $product->decrement('stock', $quantity);
            
            // Log the transaction
            InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => $user?->id ?? auth()->id(),
                'type' => 'out',
                'quantity' => $quantity,
                'current_stock' => $previousStock - $quantity, // Snapshot
                'reason' => $reason,
            ]);
        });
    }

    /**
     * Increment stock for a product.
     */
    public function incrementStock(Product $product, int $quantity, string $reason, ?User $user = null): void
    {
        DB::transaction(function () use ($product, $quantity, $reason, $user) {
            $previousStock = $product->stock;
            
            $product->increment('stock', $quantity);

            InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => $user?->id ?? auth()->id(),
                'type' => 'in',
                'quantity' => $quantity,
                'current_stock' => $previousStock + $quantity,
                'reason' => $reason,
            ]);
        });
    }
}
