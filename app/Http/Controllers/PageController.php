<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::published()->latest('published_at')->paginate(10);
        return view('pages.index', compact('pages'));
    }

    public function show($slug)
    {
        $page = Page::published()->where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('page'));
    }
}
