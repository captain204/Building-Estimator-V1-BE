<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estimator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 


class EstimatorController extends Controller
{

    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'type' => 'required|in:custom,automated',
                'work_items' => 'nullable|string',
                'specifications' => 'nullable|string',
                'to_array' => 'nullable|json',
                'variable' => 'nullable|string',
                'to_html' => 'nullable|string',
                'require_custom_building' => 'nullable|in:yes,no',
                'other_information' => 'nullable|string',
                'is_urgent' => 'boolean',
                'agree' => 'boolean',
                'custom_more' => 'boolean',
                'classes' => 'nullable|string',
            ]);

            Log::info('Validation passed.', ['data' => $validatedData]);

            // Prepare data for database insertion
            $estimator = Estimator::create([
                'user_id' => $user->id,
                'type' => $validatedData['type'],
                'work_items' => $validatedData['work_items'] ?? null,
                'specifications' => $validatedData['specifications'] ?? null,
                'to_array' => isset($validatedData['to_array']) ? json_encode(json_decode($validatedData['to_array'], true)) : null,
                'variable' => $validatedData['variable'] ?? null,
                'to_html' => $validatedData['to_html'] ?? null,
                'require_custom_building' => $validatedData['require_custom_building'] ?? null,
                'other_information' => $validatedData['other_information'] ?? null,
                'is_urgent' => $validatedData['is_urgent'] ?? false,
                'agree' => $validatedData['agree'] ?? false,
                'custom_more' => $validatedData['custom_more'] ?? false,
                'classes' => $validatedData['classes'] ?? null,
            ]);

            Log::info('Estimator created successfully.', ['estimator' => $estimator]);

            // Return success response
            return response()->json([
                'message' => 'Estimator created successfully',
                'estimator' => $estimator,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed.', ['errors' => $e->errors()]);
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating estimator.', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Failed to create estimator',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    
    
    // Get estimates by a specific user
    public function getEstimatesCountByUser($userId)
    {
        $user = User::findOrFail($userId);

        $estimates = Estimator::with('user.profile')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'message' => "Estimates for user {$user->id} retrieved successfully",
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'estimates' => $estimates,
        ], 200);
    }

    // Retrieve all estimates
    public function getAllEstimates()
    {
        $estimates = Estimator::with('user.profile')->get(); 

        return response()->json([
            'message' => 'All estimates retrieved successfully',
            'data' => $estimates,
        ], 200);
    }


    public function getUsageCountByType()
    {
        $user = Auth::user();
        $usageCountCustom = Estimator::where('user_id', $user->id)
                                    ->where('type', 'custom')
                                    ->count();

        $usageCountAutomated = Estimator::where('user_id', $user->id)
                                        ->where('type', 'automated')
                                        ->count();
        return response()->json([
            'message' => 'Usage count by type retrieved successfully',
            'user_id' => $user->id,
            'usage_count_custom' => $usageCountCustom,
            'usage_count_automated' => $usageCountAutomated,
        ], 200);
    }

    public function getAutomatedEstimates()
    {
        $estimates = Estimator::with('user.profile')->where('type', 'automated')->get();

        return response()->json([
            'message' => 'Automated estimates retrieved successfully',
            'data' => $estimates,
        ], 200);
    }

    public function getCustomEstimates()
    {
        $estimates = Estimator::with('user.profile')->where('type', 'custom')->get();

        return response()->json([
            'message' => 'Custom estimates retrieved successfully',
            'data' => $estimates,
        ], 200);
    }

    public function getEstimateById($id)
    {
        $estimate = Estimator::with('user.profile')->find($id);
    
        if (!$estimate) {
            return response()->json([
                'message' => 'Estimate not found',
            ], 404);
        }
    
        return response()->json([
            'message' => 'Estimate retrieved successfully',
            'data' => $estimate,
        ], 200);
    }
    




    
}
