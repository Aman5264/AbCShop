<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'stock',
        'is_active',
        'status',
        'is_featured',
        'sku',
        'barcode',
        'cost_price',
        'security_stock',
        'sale_price',
        'sale_start_date',
        'sale_end_date',
        'images',
        'video_url',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'cost_price' => 'decimal:2',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'images' => 'array',
    ];

    public function getIsOnSaleAttribute(): bool
    {
        if (!$this->sale_price) {
            return false;
        }

        $now = now();

        if ($this->sale_start_date && $this->sale_start_date->isFuture()) {
            return false;
        }

        if ($this->sale_end_date && $this->sale_end_date->isPast()) {
            return false;
        }

        return true;
    }

    public function getCurrentPriceAttribute(): float
    {
        return $this->is_on_sale ? (float) $this->sale_price : (float) $this->price;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
