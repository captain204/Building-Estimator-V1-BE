<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a profile for the authenticated user.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->profile) {
            return response()->json(['message' => 'User already has a profile'], 400);
        }
    
        
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'builder_type' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);
    
        $profile = Profile::create(array_merge($validatedData, ['user_id' => $user->id]));
    
        return response()->json($profile, 201);
    
    }

    /**
     * Get the profile of the authenticated user.
     */
    public function show()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        return response()->json($profile, 200);
    }

    /**
     * Update the profile of the authenticated user.
     */
    public function update(Request $request)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $validatedData = $request->validate([
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'builder_type' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'bio' => 'nullable|string',
        ]);

        $profile->update($validatedData);

        return response()->json($profile, 200);
    }

    /**
     * Delete the profile of the authenticated user.
     */
    public function delete()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 204);
    }
}
