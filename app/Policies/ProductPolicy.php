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

    public function view(User $user, Product $product): bool
    {
        return $user->role === 'admin' || $user->hasPermissionTo('manage_products') || $user->hasRole(['admin', 'manager', 'staff']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    public function update(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    public function delete(User $user, Product $product): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }

    public function deleteAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'manager', 'staff']) || $user->hasPermissionTo('manage_products');
    }
}
