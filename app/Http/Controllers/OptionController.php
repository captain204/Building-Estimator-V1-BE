<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\Option;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $options = Option::all();
            return response()->json($options, 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching options', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch options.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'question_id' => 'required|exists:questions,id',
                'type' => 'required|in:dropdown,checkbox,form',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'question' => 'nullable|string',
            ]);

            $option = Option::create($validated);
            return response()->json($option, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Option creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Unable to create option.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $option = Option::findOrFail($id);
            return response()->json($option, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error fetching option details', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch option details.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $option = Option::findOrFail($id);

            $validated = $request->validate([
                'question_id' => 'sometimes|exists:questions,id',
                'type' => 'sometimes|in:dropdown,checkbox,form',
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'question' => 'nullable|string',
            ]);

            $option->update($validated);
            return response()->json($option, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option not found.'], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Validation failed.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating option', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to update option.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $option = Option::findOrFail($id);
            $option->delete();
            return response()->json(['message' => 'Option deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Option not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting option', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to delete option.'], 500);
        }
    }
}
