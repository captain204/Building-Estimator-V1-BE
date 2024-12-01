<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallRequest;

class CallRequestController extends Controller
{
    /**
     * Create a new callback request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $callbackRequest = CallRequest::create($validated);

        return response()->json([
            'message' => 'Callback request created successfully.',
            'data' => $callbackRequest,
        ], 201);
    }

    /**
     * Get all callback requests.
     */
    public function index()
    {
        $callbackRequests = CallRequest::all();

        return response()->json([
            'message' => 'Callback requests retrieved successfully.',
            'data' => $callbackRequests,
        ], 200);
    }

    /**
     * Update the response status of a callback request.
     */
    public function updateResponse(Request $request, $id)
    {
        $callbackRequest = CallRequest::find($id);

        if (!$callbackRequest) {
            return response()->json([
                'message' => 'Callback request not found.',
            ], 404);
        }

        $callbackRequest->update(['response' => true]);

        return response()->json([
            'message' => 'Callback request response updated successfully.',
            'data' => $callbackRequest,
        ], 200);
    }

    /**
     * Delete a callback request.
    */
    public function destroy($id)
    {
        $callbackRequest = CallRequest::find($id);

        if (!$callbackRequest) {
            return response()->json([
                'message' => 'Callback request not found.',
            ], 404);
        }

        $callbackRequest->delete();

        return response()->json([
            'message' => 'Callback request deleted successfully.',
        ], 200);
    }

    /**
     * Get the total number of responses.
    */
    public function totalResponses()
    {
        $totalResponses = CallRequest::where('response', true)->count();

        return response()->json([
            'message' => 'Total number of responses retrieved successfully.',
            'total_responses' => $totalResponses,
        ], 200);
    }

}
