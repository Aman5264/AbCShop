<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Ensure an admin user exists for authorship
        $user = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Create Category
        $category = BlogCategory::firstOrCreate(
            ['slug' => 'technology'],
            ['name' => 'Technology', 'description' => 'Tech news and reviews', 'is_visible' => true]
        );

        // Create Tag
        $tag = BlogTag::firstOrCreate(
            ['slug' => 'laravel'],
            ['name' => 'Laravel']
        );

        // Create Post
        $post = BlogPost::create([
            'blog_category_id' => $category->id,
            'user_id' => $user->id,
            'title' => 'Welcome to our new Blog!',
            'slug' => 'welcome-to-our-new-blog-' . Str::random(5),
            'content' => '<p>This is the first post on our amazing new blog. We will be sharing news, tips, and updates here.</p>',
            'published_at' => now(),
            'is_visible' => true,
        ]);

        $post->tags()->attach($tag->id);

        $this->command->info('Blog data seeded successfully!');
    }
}
