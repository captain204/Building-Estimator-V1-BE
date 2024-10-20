<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Validation\ValidationException;





class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $subscriber = Subscriber::where('email', $validated['email'])->first();
        
        if ($subscriber) {
            return response()->json([
                'message' => 'The email address is already subscribed.',
            ], 422); 
        }
        Subscriber::create($validated);
        return response()->json([
            'message' => 'You have successfully subscribed to the newsletter!'
        ], 201); 
    }
}
