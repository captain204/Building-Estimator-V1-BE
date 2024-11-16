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
            $request->validate([
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users', 
                ],
                'password' => 'required|string|min:8|confirmed', 
            ]);
    
            $user = User::create([
                'name'=> $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'message' => 'Please verify your email before logging in.',
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (array_key_exists('email', $e->errors()) && in_array('The email has already been taken.', $e->errors()['email'])) {
                return response()->json([
                    'status' => 'email_exists',
                    'message' => 'A user with this email already exists. Please log in or use a different email.'
                ], 409); 
            }
            return response()->json([
                'status' => 'validation_error',
                'message' => 'Validation failed for the provided data.',
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'An error occurred during registration. Please try again.',
            ], 500);  
        }
    }
          

    
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

    
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Logged out']);
        }    
        return response()->json(['message' => 'No authenticated user found'], 401);
    
    }

    
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['email' => __($status)], 400);
    }

    
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
    
    
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 200);
        }
    
        $request->user()->sendEmailVerificationNotification();
    
        return response()->json(['message' => 'Verification link resent']);
    }

    
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    
    
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
    
    
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(uniqid())  
                ]
            );
    
            
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
    
            
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
