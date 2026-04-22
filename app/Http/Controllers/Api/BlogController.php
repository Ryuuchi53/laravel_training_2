<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index() {
        $blogs = Blog::with('user')->get();
        return response()->json([
            'status' => 'true',
            'message' => 'Index Success.',
            'data' => $blogs
        ]);
    }

    public function store(StoreBlogRequest $request) {
        $blogs = Blog::create($request->all());
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully created.',
            'data' => $blogs
        ]);
    }

    public function show($blog_api) {
        $blog = Blog::with('user')->findOrFail($blog_api);
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully retrieved.',
            'data' => $blog
        ]);
    }

    public function update(UpdateBlogRequest $request, $blog_api) {
        $blog = Blog::with('user')->findOrFail($blog_api);
        $blog->update($request->all());
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully updated.',
            'data' => $blog
        ]);
    }

    public function destroy($blog_api) {
        $blog = Blog::with('user')->findOrFail($blog_api);
        $blog->delete();
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully deleted.',
            'data' => $blog
        ]);
    }
}
