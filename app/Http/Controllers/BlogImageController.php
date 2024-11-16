<?php

namespace App\Http\Controllers;

use App\Models\BlogImage;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BlogImageController extends Controller
{
    public function store(Request $request, $id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog post not found'], 404);
        }
    
        $validated = $request->validate([
            'image_url' => 'required|url',  
            'caption' => 'nullable|string|max:255',
        ]);
    
               
       $blogImage = BlogImage::create([
            'blog_id' => $blog->id,
            'image_url' => $validated['image_url'],
            'caption' => $validated['caption'] ?? null,
        ]);

    
        return response()->json($blogImage, 201);
    
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 1) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    
        // Find the blog image by ID, return error if not found
        $blogImage = BlogImage::find($id);
        if (!$blogImage) {
            return response()->json(['error' => 'Blog image not found'], 404);
        }
    
        $validated = $request->validate([
            'image_url' => 'nullable|url', 
            'caption' => 'nullable|string|max:255', 
        ]);
    
        // Update only provided fields
        $blogImage->update(array_filter($validated));
    
        return response()->json($blogImage, 200);
    
    }

    public function destroy($id)
    {
        $blogImage = BlogImage::find($id);

        if (!$blogImage) {
            return response()->json(['error' => 'Blog image not found'], 404);
        }

        $blogImage->delete();

        return response()->json(['message' => 'Blog image deleted successfully'], 200);
    }

}
