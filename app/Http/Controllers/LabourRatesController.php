<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabourRatesRequest;
use App\Http\Requests\UpdateLabourRatesRequest;
use App\Models\LabourRates;
use Illuminate\Http\Request;


class LabourRatesController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $labourates = LabourRates::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Labour rates lists retrieved successfully.',
            'data' => $labourates,
        ], 200);
    }


    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $labourates = LabourRates::findOrFail($id);
    
            return response()->json([
                'success' => true,
                'message' => 'Labour Rates list retrieved successfully.',
                'data' => $labourates,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labour Rates not found.',
                'data' => null,
            ], 404);
        }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'area_of_work' => 'required|string',
                'lower_point_daily_rate_per_day' => 'required|string',
                'higher_point_daily_rate_per_day' => 'required|string',
                'average_point_daily_rate_per_day' => 'required|string',
                'unit_of_costing' => 'required|string',
                'lower_point_daily_rate_per_unit' => 'required|string',
                'higher_point_daily_rate_per_unit' => 'required|string',
                'average_point_daily_rate_per_unit' => 'required|string',
            ]);

            $labourates = LabourRates::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Labour rates price list created successfully.',
                'data' => $labourates,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the labour rates price list.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $labourates = LabourRates::findOrFail($id);
    
            $validated = $request->validate([
                'area_of_work' => 'required|string',
                'lower_point_daily_rate_per_day' => 'required|string',
                'higher_point_daily_rate_per_day' => 'required|string',
                'average_point_daily_rate_per_day' => 'required|string',
                'unit_of_costing' => 'required|string',
                'lower_point_daily_rate_per_unit' => 'required|string',
                'higher_point_daily_rate_per_unit' => 'required|string',
                'average_point_daily_rate_per_unit' => 'required|string',
            ]);
    
            $labourates->update($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Labour price list updated successfully.',
                'data' => $labourates,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labour Rates not found.',
                'data' => null,
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
    

    }


    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        try {
            $labourates = LabourRates::findOrFail($id);
            $labourates->delete();

            return response()->json([
                'success' => true,
                'message' => 'Labour price list deleted successfully.',
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Labour Rates not found.',
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the labour price list.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
