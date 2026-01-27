<?php

namespace App\DataStructures;

class TrieNode
{
    public $children = [];
    public $isEndOfWord = false;
    public $word = null;

    public function __construct()
    {
        $this->children = [];
        $this->isEndOfWord = false;
    }
}
