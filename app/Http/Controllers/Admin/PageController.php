<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PageService;
use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $this->pageService->create($request->validated());
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
             'title' => 'required|string|max:255',
             'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
             'content' => 'required|string',
             'status' => 'required|in:draft,published,archived',
        ]);

        $this->pageService->update($page, $request->all());
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->pageService->delete($page);
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }
}
