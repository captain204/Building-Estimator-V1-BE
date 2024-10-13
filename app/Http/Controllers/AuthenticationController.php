<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Laravel\Socialite\Facades\Socialite;


class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        try {
            // Validate input including firstname, lastname, country, and builder_type
            $request->validate([
                'firstname' => 'required|string|max:255', // Validate firstname
                'lastname' => 'required|string|max:255',  // Validate lastname
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users', // Unique email validation
                ],
                'password' => 'required|string|min:8|confirmed', // Password confirmation required
                'country' => 'required|string|max:255',  // Validate country
                'builder_type' => 'required|string|max:255',  // Validate builder_type
            ]);
    
            // Create the new user
            $user = User::create([
                'firstname' => $request->firstname,  // Assign firstname
                'lastname' => $request->lastname,    // Assign lastname
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'country' => $request->country,      // Assign country
                'builder_type' => $request->builder_type,  // Assign builder_type
            ]);
    
            // Issue Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Return response with the token and success message
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => 'Please verify your email before logging in.',
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Check if the error is related to the email already existing
            if (array_key_exists('email', $e->errors()) && in_array('The email has already been taken.', $e->errors()['email'])) {
                return response()->json([
                    'status' => 'email_exists',
                    'message' => 'A user with this email already exists. Please log in or use a different email.'
                ], 409); // 409 Conflict status code for existing resource
            }
    
            // Return other validation errors
            return response()->json([
                'status' => 'validation_error',
                'message' => 'Validation failed for the provided data.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Registration error: ' . $e->getMessage());
    
            // Return a general error message for any other exception
            return response()->json([
                'message' => 'An error occurred during registration. Please try again.',
            ], 500);  // HTTP 500 - Internal Server Error
        }
    }
          

    // Login a user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // Logout user (invalidate tokens)
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    // Send forgot password link
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['email' => __($status)], 400);
    }

    // Verify the user's email
    public function verifyEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }
    
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    
        return response()->json(['message' => 'Email verified successfully']);
    }
    
    // Resend the email verification link
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }
    
        $request->user()->sendEmailVerificationNotification();
    
        return response()->json(['message' => 'Verification link resent']);
    }

    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    //Google Auth
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
    
            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(uniqid())  // Use a random password
                ]
            );
    
            // Ensure the user is verified
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
    
            // Issue Sanctum token
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google authentication failed'], 500);
        }
    }
    


    
}
