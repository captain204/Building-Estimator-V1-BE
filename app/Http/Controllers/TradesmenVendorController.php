<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTradesmenVendorRequest;
use App\Http\Requests\UpdateTradesmenVendorRequest;
use App\Models\TradesmenVendor;

class TradesmenVendorController extends Controller
{
    public function index()
    {
        $vendors = TradesmenVendor::all();
        return response()->json($vendors, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'sub_category' => 'required|string|max:255',
            'email' => 'required|email|unique:tradesmen_vendors',
            'phone_number' => 'required|string|max:15',
            'guarantor_name' => 'required|string|max:255',
            'guarantor_contact_number' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg',
            'job_picture' => 'nullable|image|mimes:jpeg,png,jpg',
            'guarantor_id_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $vendor = TradesmenVendor::create($validated);
        return response()->json($vendor, 201);
    }

    public function show($id)
    {
        $vendor = TradesmenVendor::find($id);
        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }
        return response()->json($vendor, 200);
    }

    public function update(Request $request, $id)
    {
        $vendor = TradesmenVendor::find($id);
        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'sub_category' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:tradesmen_vendors,email,' . $vendor->id,
            'phone_number' => 'sometimes|string|max:15',
            'guarantor_name' => 'sometimes|string|max:255',
            'guarantor_contact_number' => 'sometimes|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg',
            'job_picture' => 'nullable|image|mimes:jpeg,png,jpg',
            'guarantor_id_image' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $vendor->update($validated);
        return response()->json($vendor, 200);
    }

    public function destroy($id)
    {
        $vendor = TradesmenVendor::find($id);
        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found'], 404);
        }

        $vendor->delete();
        return response()->json(['message' => 'Vendor deleted successfully'], 200);
    }

}
