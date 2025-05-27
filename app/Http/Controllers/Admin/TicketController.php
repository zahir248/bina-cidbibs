<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::latest()->get();
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:tickets',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'categories' => 'nullable|array',
            'categories.*' => 'string',
            'can_select_quantity' => 'boolean',
            'quantity_discounts' => 'nullable|array',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle checkbox
        $validated['can_select_quantity'] = $request->has('can_select_quantity') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
        }

        // Handle categories
        if (isset($validated['categories'])) {
            $validated['categories'] = $validated['categories'];
        }

        if (isset($validated['quantity_discounts'])) {
            $validated['quantity_discounts'] = $validated['quantity_discounts'];
        }

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // Only decode if it's a string
        if (is_string($ticket->categories)) {
            $ticket->categories = json_decode($ticket->categories);
        }
        if (is_string($ticket->quantity_discounts)) {
            $ticket->quantity_discounts = json_decode($ticket->quantity_discounts);
        }
        return view('admin.tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:50|unique:tickets,sku,' . $ticket->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'categories' => 'nullable|array',
            'categories.*' => 'string',
            'can_select_quantity' => 'boolean',
            'quantity_discounts' => 'nullable|array',
            'additional_info' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle checkbox
        $validated['can_select_quantity'] = $request->has('can_select_quantity') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($ticket->image && file_exists(public_path($ticket->image))) {
                unlink(public_path($ticket->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
        }

        // Handle categories - use existing if not provided
        if (!isset($validated['categories'])) {
            $validated['categories'] = $ticket->categories;
        }

        if (isset($validated['quantity_discounts'])) {
            $validated['quantity_discounts'] = $validated['quantity_discounts'];
        }

        $ticket->update($validated);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        // Delete image if exists
        if ($ticket->image && file_exists(public_path($ticket->image))) {
            unlink(public_path($ticket->image));
        }

        $ticket->delete();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
} 