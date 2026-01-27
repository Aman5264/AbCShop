<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PRODUCTS
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'is_active')) {
                    try {
                        $table->index('is_active');
                    } catch (\Throwable $e) {}
                }

                if (Schema::hasColumn('products', 'price')) {
                    try {
                        $table->index('price');
                    } catch (\Throwable $e) {}
                }
            });
        }

        // ORDERS
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'status')) {
                    try {
                        $table->index('status');
                    } catch (\Throwable $e) {}
                }

                if (Schema::hasColumn('orders', 'created_at')) {
                    try {
                        $table->index('created_at');
                    } catch (\Throwable $e) {}
                }
            });
        }

        // BLOG POSTS
        if (Schema::hasTable('blog_posts')) {
            Schema::table('blog_posts', function (Blueprint $table) {
                if (Schema::hasColumn('blog_posts', 'status')) {
                    try {
                        $table->index('status');
                    } catch (\Throwable $e) {}
                }

                if (Schema::hasColumn('blog_posts', 'published_at')) {
                    try {
                        $table->index('published_at');
                    } catch (\Throwable $e) {}
                }
            });
        }
    }

    public function down(): void
    {
        // PRODUCTS
        Schema::table('products', function (Blueprint $table) {
            try { $table->dropIndex(['is_active']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['price']); } catch (\Throwable $e) {}
        });

        // ORDERS
        Schema::table('orders', function (Blueprint $table) {
            try { $table->dropIndex(['status']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['created_at']); } catch (\Throwable $e) {}
        });

        // BLOG POSTS
        Schema::table('blog_posts', function (Blueprint $table) {
            try { $table->dropIndex(['status']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['published_at']); } catch (\Throwable $e) {}
        });
    }
};
