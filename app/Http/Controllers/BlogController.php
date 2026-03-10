<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(5);

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
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog berjaya dikemaskini');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berjaya dipadam');
    }
}
