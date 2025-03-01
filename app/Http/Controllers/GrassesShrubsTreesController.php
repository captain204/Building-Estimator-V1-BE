<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrassesShrubsTrees;
use Illuminate\Http\JsonResponse;

class GrassesShrubsTreesController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Check if a record already exists
        if (GrassesShrubsTrees::exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A record already exists. You can only update it.'
            ], 400);
        }

        $validated = $request->validate([
            'qty_area' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'rate' => 'required|numeric',
            'amount' => 'required|numeric',
            'no_of_days' => 'required|integer|min:1',
        ]);

        $grassesAndShrubsTrees = GrassesShrubsTrees::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record created successfully',
            'data' => $grassesAndShrubsTrees
        ], 201);
    }

    public function show(): JsonResponse
    {
        $grassesAndShrubsTrees = GrassesShrubsTrees::first();

        if (!$grassesAndShrubsTrees) {
            return response()->json([
                'success' => false,
                'message' => 'No record found. Please create one first.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record retrieved successfully',
            'data' => $grassesAndShrubsTrees
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $grassesAndShrubsTrees = GrassesShrubsTrees::first();

        if (!$grassesAndShrubsTrees) {
            return response()->json([
                'success' => false,
                'message' => 'No record found. Please create one first.'
            ], 404);
        }

        $validated = $request->validate([
            'qty_area' => 'numeric',
            'unit' => 'string|max:50',
            'rate' => 'numeric',
            'amount' => 'numeric',
            'no_of_days' => 'integer|min:1',
        ]);

        $grassesAndShrubsTrees->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record updated successfully',
            'data' => $grassesAndShrubsTrees
        ], 200);
    }
}
