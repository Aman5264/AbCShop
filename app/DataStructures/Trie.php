<?php

namespace App\DataStructures;

class Trie
{
    private $root;

    public function __construct()
    {
        $this->root = new TrieNode();
    }

    /**
     * Insert a word into the trie.
     */
    public function insert(string $word)
    {
        $node = $this->root;
        $length = strlen($word);

        for ($i = 0; $i < $length; $i++) {
            $char = strtolower($word[$i]);
            
            if (!isset($node->children[$char])) {
                $node->children[$char] = new TrieNode();
            }
            $node = $node->children[$char];
        }

        $node->isEndOfWord = true;
        // Store the original case word for display purposes
        $node->word = $word;
    }

    /**
     * Search for words starting with the given prefix.
     */
    public function search(string $prefix, int $limit = 5): array
    {
        $node = $this->root;
        $length = strlen($prefix);
        $results = [];

        // Traverse to the end of the prefix
        for ($i = 0; $i < $length; $i++) {
            $char = strtolower($prefix[$i]);
            
            if (!isset($node->children[$char])) {
                return [];
            }
            $node = $node->children[$char];
        }

        // Perform DFS to find all complete words from this node
        $this->dfs($node, $results, $limit);

        return $results;
    }

    private function dfs(TrieNode $node, array &$results, int $limit)
    {
        if (count($results) >= $limit) {
            return;
        }

        if ($node->isEndOfWord) {
            $results[] = $node->word;
        }

        // Sort keys to ensure consistent order (optional) but keys are chars
        foreach ($node->children as $child) {
            if (count($results) >= $limit) break;
            $this->dfs($child, $results, $limit);
        }
    }
}
