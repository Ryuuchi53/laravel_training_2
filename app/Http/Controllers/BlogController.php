<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('user')
            ->where(function ($query) {
                $query->when(request()->filled('title'), function ($query) {
                    $query->where('title', 'like', '%' . request()->title . '%')
                        ->orWhere('content', 'like', '%' . request()->title . '%');
                });

                $query->when(request()->filled('mytask'), function ($query) {
                    if (request()->mytask == 1) {
                        $query->where('created_by', auth()->id());
                    }
                });
            })
            ->orderBy('updated_at', 'desc')
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

    public function store(StoreBlogRequest $request)
    {
        $validated = $request->validated();

        $blog = new Blog();
        $blog->fill($request->validated());
        $blog->created_by = $validated(auth()->id());
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

    public function update(UpdateBlogRequest $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->fill($request->validated());
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
