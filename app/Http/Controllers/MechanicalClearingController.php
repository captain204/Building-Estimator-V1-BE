<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MechanicalClearing;
use Illuminate\Http\JsonResponse;

class MechanicalClearingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Check if a record already exists for the given category
        if (MechanicalClearing::where('category', $request->category)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A record for this category already exists. You can only update it.'
            ], 400);
        }

        $validated = $request->validate([
            'area_of_land' => 'required|integer',
            'preliminary_needed' => 'required|string|max:255',
            'no_of_days' => 'required|integer|min:1',
            'category' => 'required|in:non_waterlogged,unstable_ground,swampy',
        ]);

        $mechanicalClearing = MechanicalClearing::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mechanical Clearing record created successfully',
            'data' => $mechanicalClearing
        ], 201);
    }

    public function show(): JsonResponse
    {
        $mechanicalClearings = MechanicalClearing::all();

        if ($mechanicalClearings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No records found. Please create one first.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mechanical Clearing records retrieved successfully',
            'data' => $mechanicalClearings
        ], 200);
    }

    public function update(Request $request, $category): JsonResponse
    {
        $mechanicalClearing = MechanicalClearing::where('category', $category)->first();

        if (!$mechanicalClearing) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this category. Please create one first.'
            ], 404);
        }

        $validated = $request->validate([
            'area_of_land' => 'integer',
            'preliminary_needed' => 'string|max:255',
            'no_of_days' => 'integer|min:1',
            'category' => 'in:non_waterlogged,unstable_ground,swampy',
        ]);

        $mechanicalClearing->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mechanical Clearing record updated successfully',
            'data' => $mechanicalClearing
        ], 200);
    }

    public function showByCategory($category): JsonResponse
    {
        $mechanicalClearing = MechanicalClearing::where('category', $category)->first();

        if (!$mechanicalClearing) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this category.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mechanical Clearing record retrieved successfully',
            'data' => $mechanicalClearing
        ], 200);
    }

    public function destroy($category): JsonResponse
    {
        $mechanicalClearing = MechanicalClearing::where('category', $category)->first();

        if (!$mechanicalClearing) {
            return response()->json([
                'success' => false,
                'message' => 'No record found for this category.'
            ], 404);
        }

        $mechanicalClearing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mechanical Clearing record deleted successfully'
        ], 200);
    }

}
