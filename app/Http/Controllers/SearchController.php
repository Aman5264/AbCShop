<?php

namespace App\Http\Controllers;

use App\Services\TrieSearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $trieService;

    public function __construct(TrieSearchService $trieService)
    {
        $this->trieService = $trieService;
    }

    public function autocomplete(Request $request)
    {
        $query = $request->input('query');
        
        if (!$query) {
            return response()->json([]);
        }

        $suggestions = $this->trieService->search($query);

        return response()->json($suggestions);
    }
}
