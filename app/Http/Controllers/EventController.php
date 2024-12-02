<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Create a new event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'location' => 'nullable|string|max:255',
        ]);

        // Handle image upload to S3
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 's3');
            $validated['image_path'] = Storage::disk('s3')->url($path);
        } else {
            $validated['image_path'] = null;
        }

        #$validated['slug'] = \Str::slug($validated['title']);

        $event = Event::create($validated);

        return response()->json([
            'message' => 'Event created successfully.',
            'data' => $event,
        ], 201);
    }


    /**
     * Get all events.
     */
    public function index()
    {
        $events = Event::all();

        return response()->json([
            'message' => 'Events retrieved successfully.',
            'data' => $events,
        ], 200);
    }

    /**
     * Get a single event.
     */
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Event retrieved successfully.',
            'data' => $event,
        ], 200);
    }

    /**
     * Update an event.
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found.',
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'event_date' => 'date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'location' => 'string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($event->image_path && Storage::exists('public/' . $event->image_path)) {
                Storage::delete('public/' . $event->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('uploads/events', 'public');
        }

        $event->update($validated);

        return response()->json([
            'message' => 'Event updated successfully.',
            'data' => $event,
        ], 200);
    }

    /**
     * Delete an event.
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'message' => 'Event not found.',
            ], 404);
        }

        if ($event->image_path && Storage::exists('public/' . $event->image_path)) {
            Storage::delete('public/' . $event->image_path);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully.',
        ], 200);
    }
}
