<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // categories
        // categories - using Unsplash images that look like category icons/thumbnails
        $electronics = Category::create([
            'name' => 'Electronics', 
            'slug' => 'electronics', 
            'description' => 'Gadgets and devices',
            'image' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?auto=format&fit=crop&w=200&q=80' // Electronics icon/image
        ]);
        $clothing = Category::create([
            'name' => 'Clothing', 
            'slug' => 'clothing', 
            'description' => 'Apparel for all',
            'image' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=200&q=80' // Clothing icon/image
        ]);
        $home = Category::create([
            'name' => 'Home & Garden', 
            'slug' => 'home-garden', 
            'description' => 'Decor and tools',
            'image' => 'https://images.unsplash.com/photo-1616046229478-9901c5536a45?auto=format&fit=crop&w=200&q=80' // Home icon/image
        ]);

        $laptops = Category::create([
            'name' => 'Laptops', 
            'slug' => 'laptops', 
            'parent_id' => $electronics->id,
            'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=200&q=80'
        ]);
        $phones = Category::create([
            'name' => 'Smartphones', 
            'slug' => 'smartphones', 
            'parent_id' => $electronics->id,
            'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=200&q=80'
        ]);
        $shirts = Category::create([
            'name' => 'Shirts', 
            'slug' => 'shirts', 
            'parent_id' => $clothing->id,
            'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=200&q=80'
        ]);

        // Products
        $products = [
            [
                'name' => 'MacBook Pro',
                'description' => 'Powerful laptop for professionals.',
                'price' => 1999.99,
                'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8',
                'stock' => 10,
                'category_id' => $laptops->id
            ],
            [
                'name' => 'iPhone 15',
                'description' => 'The latest smartphone from Apple.',
                'price' => 999.99,
                'image_url' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569',
                'stock' => 20,
                'category_id' => $phones->id
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Android flagship with AI features.',
                'price' => 899.99,
                'image_url' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c',
                'stock' => 15,
                'category_id' => $phones->id
            ],
            [
                'name' => 'Classic White T-Shirt',
                'description' => '100% Cotton, comfortable fit.',
                'price' => 19.99,
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab',
                'stock' => 50,
                'category_id' => $shirts->id
            ],
            [
                'name' => 'Modern Sofa',
                'description' => 'Comfortable 3-seater sofa.',
                'price' => 499.00,
                'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc',
                'stock' => 5,
                'category_id' => $home->id
            ]
        ];

        foreach($products as $prod) {
            $category_id = $prod['category_id'];
            unset($prod['category_id']);
            
            $product = Product::create($prod);
            $product->categories()->attach($category_id);
            // Also link to parent category if exists
            $cat = Category::find($category_id);
            if($cat->parent_id) {
                $product->categories()->attach($cat->parent_id);
            }
        }

        // Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Admin User
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');
    }
}
