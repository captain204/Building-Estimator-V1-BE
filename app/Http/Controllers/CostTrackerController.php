<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CostTracker;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CostTrackerController extends Controller
{
    // Fetch all cost tracker entries
    public function index()
    {
        $costTrackers = CostTracker::all();

        return response()->json([
            'success' => true,
            'message' => 'Cost trackers retrieved successfully.',
            'data' => $costTrackers,
        ]);
    }

    // Create a new cost tracker entry
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:cost_trackers,name',
                'details' => 'nullable|string|max:1000',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0.01',
            ]);

            $costTracker = CostTracker::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Cost tracker created successfully.',
                'data' => $costTracker,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    // Show a single cost tracker entry
    public function show($id)
    {
        $costTracker = CostTracker::find($id);

        if (!$costTracker) {
            return response()->json([
                'success' => false,
                'message' => 'Cost tracker not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cost tracker retrieved successfully.',
            'data' => $costTracker,
        ]);
    }

    // Update an existing cost tracker entry
    public function update(Request $request, $id)
    {
        $costTracker = CostTracker::find($id);

        if (!$costTracker) {
            return response()->json([
                'success' => false,
                'message' => 'Cost tracker not found.',
            ], 404);
        }

        try {
            $data = $request->validate([
                'name' => 'required|string|max:255|unique:cost_trackers,name,' . $id,
                'details' => 'nullable|string|max:1000',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0.01',
            ]);

            $costTracker->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Cost tracker updated successfully.',
                'data' => $costTracker,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    // Delete a cost tracker entry
    public function destroy($id)
    {
        $costTracker = CostTracker::find($id);

        if (!$costTracker) {
            return response()->json([
                'success' => false,
                'message' => 'Cost tracker not found.',
            ], 404);
        }

        $costTracker->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cost tracker deleted successfully.',
        ]);
    }
}
