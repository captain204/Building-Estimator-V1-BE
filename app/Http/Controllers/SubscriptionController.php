<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail; 
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


    /*
    * Total number of subscribers
    */
    public function totalSubscribers()
    {
        $totalSubscribers = Subscriber::count();

        return response()->json([
            'total_subscribers' => $totalSubscribers,
        ]);
    }

    public function sendNewsletter(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
    
        $subscribers = Subscriber::where('status', 'subscribed')->get(['email']);
    
        $successCount = 0;
        $failedEmails = [];
    
        try {
            foreach ($subscribers as $subscriber) {
                try {
                    Mail::to($subscriber->email)->send(new NewsletterMail($validated['subject'], $validated['body'], $subscriber->email));
                    $successCount++;
                } catch (\Exception $e) {
                    $failedEmails[] = $subscriber->email;
                }
            }
    
            return response()->json([
                'message' => 'Newsletter sending process completed.',
                'total_subscribers' => $subscribers->count(),
                'success_count' => $successCount,
                'failed_count' => count($failedEmails),
                'failed_emails' => $failedEmails,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while sending the newsletter.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function unsubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $subscriber = Subscriber::where('email', $validated['email'])->first();

        if (!$subscriber) {
            return response()->json([
                'message' => 'The email address is not subscribed.',
            ], 404);
        }

        $subscriber->status = 'unsubscribed';
        $subscriber->save();

        return response()->json([
            'message' => 'You have successfully unsubscribed from the newsletter.',
        ], 200);
    }


    public function totalUnsubscribed()
    {
        $totalUnsubscribed = Subscriber::where('status', 'unsubscribed')->count();

        return response()->json([
            'total_unsubscribed' => $totalUnsubscribed,
        ]);
    }

}
