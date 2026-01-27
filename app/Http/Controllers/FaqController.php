<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = FaqCategory::where('is_active', true)
            ->with(['faqs' => function($query) use ($search) {
                $query->where('is_active', true);
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('question', 'like', "%{$search}%")
                          ->orWhere('answer', 'like', "%{$search}%");
                    });
                }
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn($category) => $category->faqs->count() > 0);

        return view('faq.index', compact('categories', 'search'));
    }

    public function incrementViews(Faq $faq)
    {
        $faq->increment('view_count');
        return response()->json(['success' => true]);
    }
}
