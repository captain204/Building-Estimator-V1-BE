<?php

namespace App\Http\Controllers;

use App\Models\SubOption;
use Illuminate\Http\Request;

class SubOptionController extends Controller
{
    /**
     * Display a listing of sub-options.
     */
    public function index()
    {
        $subOptions = SubOption::all();
        return response()->json($subOptions, 200);
    }

    /**
     * Store a newly created sub-option.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'option_id' => 'required|exists:options,id',
            'name' => 'required|string|max:255',
            'type' => 'nullable|in:dropdown,checkbox,form',
            'description' => 'nullable|string',
            'question' => 'nullable|string',
            'is_required' => 'boolean',
        ]);

        $subOption = SubOption::create($validatedData);
        return response()->json($subOption, 201);
    }

    /**
     * Display the specified sub-option.
     */
    public function show($id)
    {
        $subOption = SubOption::find($id);

        if (!$subOption) {
            return response()->json(['message' => 'SubOption not found'], 404);
        }

        return response()->json($subOption, 200);
    }

    /**
     * Update the specified sub-option.
     */
    public function update(Request $request, $id)
    {
        $subOption = SubOption::find($id);

        if (!$subOption) {
            return response()->json(['message' => 'SubOption not found'], 404);
        }

        $validatedData = $request->validate([
            'option_id' => 'sometimes|exists:options,id',
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:dropdown,checkbox,form',
            'description' => 'nullable|string',
            'question' => 'nullable|string',
            'is_required' => 'boolean',
        ]);

        $subOption->update($validatedData);
        return response()->json($subOption, 200);
    }

    /**
     * Remove the specified sub-option.
     */
    public function destroy($id)
    {
        $subOption = SubOption::find($id);

        if (!$subOption) {
            return response()->json(['message' => 'SubOption not found'], 404);
        }

        $subOption->delete();
        return response()->json(['message' => 'SubOption deleted successfully'], 200);
    }
}
