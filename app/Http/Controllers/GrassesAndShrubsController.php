<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GrassesAndShrubs;
use Illuminate\Http\JsonResponse;

class GrassesAndShrubsController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // Check if a record already exists
        if (GrassesAndShrubs::exists()) {
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

        $grassesAndShrubs = GrassesAndShrubs::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record created successfully',
            'data' => $grassesAndShrubs
        ], 201);
    }

    public function show(): JsonResponse
    {
        $grassesAndShrubs = GrassesAndShrubs::first();

        if (!$grassesAndShrubs) {
            return response()->json([
                'success' => false,
                'message' => 'No record found. Please create one first.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record retrieved successfully',
            'data' => $grassesAndShrubs
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        $grassesAndShrubs = GrassesAndShrubs::first();

        if (!$grassesAndShrubs) {
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

        $grassesAndShrubs->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Grasses and Shrubs record updated successfully',
            'data' => $grassesAndShrubs
        ], 200);
    }
}
