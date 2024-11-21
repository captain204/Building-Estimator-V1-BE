<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstimateCategoryRequest;
use App\Http\Requests\UpdateEstimateCategoryRequest;
use App\Models\EstimateCategory;
use Illuminate\Http\Request;


class EstimateCategoryController extends Controller
{
    
    public function index()
    {
        // Get all categories
        $categories = EstimateCategory::all();

        return response()->json(['categories' => $categories], 200);
    }

    public function show($id)
    {
        // Get a single category by ID
        $category = EstimateCategory::findOrFail($id);

        return response()->json(['category' => $category], 200);
    }
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = EstimateCategory::create($data);

        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        $category = EstimateCategory::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
    }

    public function destroy($id)
    {
        $category = EstimateCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

}
