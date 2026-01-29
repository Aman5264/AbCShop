<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin' || $user->hasPermissionTo('manage_products') || $user->hasRole(['admin', 'manager', 'staff']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->role === 'admin' || $user->hasPermissionTo('manage_products') || $user->hasRole(['admin', 'manager', 'staff']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    /**
     * Determine whether the user can bulk delete models.
     */
    public function deleteAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }
}
