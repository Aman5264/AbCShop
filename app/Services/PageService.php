<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Str;

class PageService
{
    public function create(array $data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['title'], $data['slug'] ?? null);
        
        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return Page::create($data);
    }

    public function update(Page $page, array $data)
    {
        if (isset($data['title']) || isset($data['slug'])) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $data['slug'] ?? null, $page->id);
        }

        if (($data['status'] ?? $page->status) === 'published' && empty($page->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $page->update($data);
        return $page;
    }

    public function delete(Page $page)
    {
        // Check for references if needed?
        // simple soft delete
        $page->delete();
    }

    protected function generateUniqueSlug($title, $slug = null, $ignoreId = null)
    {
        $slug = $slug ? Str::slug($slug) : Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Page::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
