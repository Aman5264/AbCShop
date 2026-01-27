<?php

namespace App\Services;

use App\DataStructures\Trie;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class TrieSearchService
{
    protected $trie;

    public function __construct()
    {
        // Cache the entire Trie structure? Or rebuild it?
        // Rebuilding from a cached list of names is likely cleaner and fast enough for <10k items.
        // Serialization of complex objects can be messy.
        
        $this->trie = new Trie();
        $this->buildTrie();
    }

    protected function buildTrie()
    {
        // Get all product names. Cache this query result.
        $names = Cache::remember('product_names_list', 3600, function () {
            return Product::pluck('name')->toArray();
        });

        foreach ($names as $name) {
            $this->trie->insert($name);
        }
    }

    public function search(string $query, int $limit = 5)
    {
        if (strlen($query) < 2) {
            return [];
        }
        
        return $this->trie->search($query, $limit);
    }
}
