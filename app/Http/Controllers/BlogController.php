<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::where(function ($query) {
            $query->when(request()->filled('title'), function ($query) {
                $query->where('title', 'like', '%' . request()->title . '%')
                    ->orWhere('content', 'like', '%' . request()->title . '%');
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        return view('blogs.show', compact('blog'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        $blog = new Blog();
        $blog->title = $title;
        $blog->content = $content;
        $blog->created_by = auth()->user()->id;
        if ($request->hasFile('attachment')) {
            $blog->attachment = $request->file('attachment')->store('blog-attachment', 'public');
        }

        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog berjaya ditambah');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);

        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        $blog = Blog::findOrFail($id);
        $blog->title = $title;
        $blog->content = $content;
        if ($blog->attachment) {
            Storage::disk('public')->delete($blog->attachment);
        }
        if ($request->hasFile('attachment')) {
            $blog->attachment = $request->file('attachment')->store('blog-attachment', 'public');
        }
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog berjaya dikemaskini');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->attachment) {
            Storage::disk('public')->delete($blog->attachment);
        }
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berjaya dipadam');
    }
}
