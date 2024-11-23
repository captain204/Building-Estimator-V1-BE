<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $questions = Question::all();
            return response()->json($questions, 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching questions', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch questions.'], 500);
        }
    
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:estimate_categories,id',
                'text' => 'required|string|max:255',
                'type' => 'required|string|max:50',
                'step' => 'nullable|integer',
            ]);

            $question = Question::create($validated);
            return response()->json($question, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage(), 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Question creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Unable to create question.'], 500);        
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $question = Question::with('category', 'options')->findOrFail($id);
            return response()->json($question, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Question not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch question details.'], 500);
        }

    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            
            $question = Question::findOrFail($id);

            $validated = $request->validate([
                'category_id' => 'sometimes|exists:estimate_categories,id',
                'text' => 'sometimes|string|max:255',
                'type' => 'sometimes|string|max:50',
                'step' => 'nullable|integer',
            ]);

            $question->update($validated);
            return response()->json($question, 200);
        } catch (ModelNotFoundException $e) {
            
            return response()->json(['error' => 'Question not found.'], 404);
        } catch (ValidationException $e) {
            
            return response()->json(['error' => 'Validation failed.', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to update question.'], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();
            return response()->json(['message' => 'Question deleted successfully.'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Question not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to delete question.'], 500);
        }
    }
}
