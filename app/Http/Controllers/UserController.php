<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new admin.
     */
    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 1, 
        ]);

        return response()->json([
            'message' => 'Admin created successfully.',
            'data' => $admin,
        ], 201);
    }

    /**
     * Update an admin.
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::where('role', 1)->findOrFail($id);

        $admin->update($request->only(['name', 'email']));

        return response()->json([
            'message' => 'Admin updated successfully.',
            'data' => $admin,
        ]);
    }

    /**
     * Delete an admin.
     */
    public function deleteAdmin($id)
    {
        $admin = User::where('role', 1)->findOrFail($id);

        $admin->delete();

        return response()->json([
            'message' => 'Admin deleted successfully.',
        ]);
    }

    /**
     * Get all admins.
    */
    public function getAllAdmins()
    {
        $admins = User::where('role', 1)->get();

        return response()->json([
            'message' => 'Admins retrieved successfully.',
            'data' => $admins,
        ], 200);
    }

    /**
     * Get all verified users.
     */
    public function getVerifiedUsers()
    {
        $verifiedUsers = User::whereNotNull('email_verified_at')->get();

        return response()->json([
            'data' => $verifiedUsers,
        ]);
    }

    /**
     * Get all unverified users.
     */
    public function getUnverifiedUsers()
    {
        $unverifiedUsers = User::whereNull('email_verified_at')->get();

        return response()->json([
            'message' => 'Unverified users retrieved successfully.',
            'data' => $unverifiedUsers,
        ]);
    }

    /**
     * Get all registered users (excluding admins) with their profiles.
    */
    public function getAllUsers()
    {
        $users = User::with('profile')
            ->where('role', '!=', 1) 
            ->get();

        return response()->json([
            'message' => 'Users retrieved successfully.',
            'data' => $users,
        ]);
    }

    /**
     * Ban a user.
    */
    public function banUser($id)
    {
        try {
            // Find the user by ID, if not found it will throw a ModelNotFoundException
            $user = User::findOrFail($id);

            // Update the user's 'is_banned' status to true
            $user->update([
                'is_banned' => true,
            ]);

            // Return a success message with user data
            return response()->json([
                'message' => 'User banned successfully.',
                'data' => $user, // Return the updated user data
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case when the user is not found
            return response()->json([
                'message' => 'User not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            // Handle any other unexpected errors
            return response()->json([
                'message' => 'An error occurred while banning the user.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
    * Unban a user.
    */
    public function unbanUser($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_banned' => false,
        ]);

        return response()->json([
            'message' => 'User unbanned successfully.',
        ]);
    }

    /**
     * Get all banned users.
    */
    public function getBannedUsers()
    {
        try {
            $bannedUsers = User::where('is_banned', true)->get();
            if ($bannedUsers->isEmpty()) {
                return response()->json([
                    'message' => 'No banned users found.',
                    'data' => [], 
                ], 200);
            }
            return response()->json([
                'message' => 'Banned users retrieved successfully.',
                'data' => $bannedUsers, 
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching banned users.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get total count of all users.
    */
    public function countAllUsers()
    {
        // Count the total number of users
        $count = User::count();

        return response()->json([
            'total_users' => $count,
        ]);
    }

    /**
     * Get total count of verified users.
    */
    public function countVerifiedUsers()
    {
        $count = User::whereNotNull('email_verified_at')->count();

        return response()->json([
            'total_verified_users' => $count,
        ]);
    }

    /**
     * Get total count of unverified users.
     */
    public function countUnverifiedUsers()
    {
        $count = User::whereNull('email_verified_at')->count();

        return response()->json([
            'total_unverified_users' => $count,
        ]);
    }

    /**
     * Get total count of banned users.
     */
    public function countBannedUsers()
    {
        $count = User::where('is_banned', true)->count();

        return response()->json([
            'total_banned_users' => $count,
        ]);
    }


}
