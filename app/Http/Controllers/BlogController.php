<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index()
    {
        // Include user names for each blog
        $blogs = Blog::with('user:id,name')->get()->map(function ($blog) {
            $blog->author = $blog->user->name;
            return $blog;
        });
        
        return response()->json($blogs);
    }

    public function create(Request $request)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $blog = Auth::user()->blogs()->create($validated);

        // Add the user's name to the response
        $blog->author = Auth::user()->name;

        return response()->json($blog, 201);
    }

    public function show($id)
    {
        try {
            $blog = Blog::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }
    
        $response = [
            'id' => $blog->id,
            'title' => $blog->title,
            'content' => $blog->content,
            'user_id' => $blog->user_id,
            'created_at' => $blog->created_at,
            'updated_at' => $blog->updated_at,
            'author' => $blog->user ? $blog->user->name : 'Guest Author',
        ];
        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $blog = Blog::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $blog->update($validated);
        $response = [
            'id' => $blog->id,
            'title' => $blog->title,
            'content' => $blog->content,
            'author' => Auth::user()->name, 
            'updated_at' => $blog->updated_at,
        ];
        return response()->json($response);
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $blog = Blog::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog post deleted']);
    }
}
