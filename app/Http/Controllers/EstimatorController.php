<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estimator;
use Illuminate\Support\Facades\Auth;



class EstimatorController extends Controller
{

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'type' => 'required|in:custom,automated',
            'work_items' => 'nullable|string',
            'specifications' => 'nullable|string',
            'to_array' => 'nullable|json',
            'variable' => 'nullable|string',
            'to_html' => 'nullable|string',
            'require_custom_building' => 'nullable|in:1,2,3',
            'other_information' => 'nullable|string',
            'is_urgent' => 'boolean',
            'agree' => 'boolean',
            'custom_more' => 'boolean',
            'classes' => 'nullable|string',
        ]);
        try {
            $estimator = Estimator::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'work_items' => $request->work_items,
                'specifications' => $request->specifications,
                'to_array' => $request->to_array ? json_decode($request->to_array, true) : null,
                'variable' => $request->variable,
                'to_html' => $request->to_html,
                'require_custom_building' => $request->require_custom_building,
                'other_information' => $request->other_information,
                'is_urgent' => $request->is_urgent ?? 1,
                'agree' => $request->agree ?? 0,
                'custom_more' => $request->custom_more ?? 0,
                'classes' => $request->classes,
            ]);
        
            return response()->json([
                'message' => 'Estimator created successfully',
                'estimator' => $estimator,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating estimator:', ['error' => $e->getMessage()]);
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
