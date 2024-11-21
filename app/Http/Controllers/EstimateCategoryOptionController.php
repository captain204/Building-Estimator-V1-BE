<?php
namespace App\Http\Controllers;

use App\Models\EstimateCategoryOption;
use Illuminate\Http\Request;

class EstimateCategoryOptionController extends Controller
{
    public function index()
    {
        $options = EstimateCategoryOption::with('category')->get();
        return response()->json(['options' => $options], 200);
    }

    public function show($id)
    {
        $option = EstimateCategoryOption::with('category')->findOrFail($id);
        return response()->json(['option' => $option], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:estimate_categories,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:dropdown,checkbox,form',
            'options' => 'nullable|array',
            'description' => 'nullable|string',
        ]);

        $existingOption = EstimateCategoryOption::where('category_id', $data['category_id'])->first();

        if ($existingOption) {
            return response()->json([
                'message' => 'An option already exists for this category. Please make an update request instead.',
                'existing_option' => $existingOption
            ], 409); 
        }

        $option = EstimateCategoryOption::create($data);

        return response()->json(['message' => 'Option created successfully', 'option' => $option], 201);
    }



    public function update(Request $request, $id)
    {
        
        $option = EstimateCategoryOption::find($id);
    
        if (!$option) {
            return response()->json(['message' => 'Category option not found'], 404); // HTTP 404 Not Found
        }
    
        $data = $request->validate([
            'category_id' => 'required|exists:estimate_categories,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:dropdown,checkbox,form',
            'options' => 'nullable|array',
            'description' => 'nullable|string',
        ]);
    
        $option->update($data);
    
        return response()->json(['message' => 'Option updated successfully', 'option' => $option], 200); // HTTP 200 OK
    }
    

    public function destroy($id)
    {
        $option = EstimateCategoryOption::findOrFail($id);
        $option->delete();
        return response()->json(['message' => 'Option deleted successfully'], 200);
    }

    public function getByCategory($categoryId)
    {
        $options = EstimateCategoryOption::where('category_id', $categoryId)->get();
        if ($options->isEmpty()) {
            return response()->json(['message' => 'No options found for this category'], 404);
        }
    
        return response()->json(['options' => $options], 200);    
    }

}
