<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    private $availableSlugs = [
        'modular-asia',
        'facility-management'
    ];

    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $events = $query->latest()->paginate(10)->withQueryString();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $availableSlugs = $this->availableSlugs;
        return view('admin.events.create', compact('availableSlugs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'location' => 'nullable|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organizer' => 'nullable|max:255',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'slug' => 'required|in:' . implode(',', $this->availableSlugs)
        ]);

        // Ensure checkboxes are set to 0 if not checked
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $imageName);
            $validated['image'] = 'images/events/' . $imageName;
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        $availableSlugs = $this->availableSlugs;
        return view('admin.events.edit', compact('event', 'availableSlugs'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'location' => 'nullable|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'organizer' => 'nullable|max:255',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'slug' => 'required|in:' . implode(',', $this->availableSlugs)
        ]);

        // Ensure checkboxes are set to 0 if not checked
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_published'] = $request->has('is_published') ? 1 : 0;

        // Only update fields that are provided
        $updateData = array_filter($validated, function($value) {
            return $value !== null;
        });

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/events'), $imageName);
            $updateData['image'] = 'images/events/' . $imageName;
        }

        $event->update($updateData);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }
} 