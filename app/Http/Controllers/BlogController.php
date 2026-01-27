<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('category', 'author')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->whereNotNull('published_at')
            ->with(['category', 'tags', 'comments.user'])
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function comment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = BlogPost::where('slug', $slug)->firstOrFail();

        BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'is_approved' => true, // Auto-approve for now
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }
}
