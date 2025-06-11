<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Event;
use App\Models\Schedule;

class PageController extends Controller
{
    public function home()
    {
        return view('client.home');
    }

    public function store()
    {
        $tickets = \App\Models\Ticket::all();
        $sessionId = request()->session()->getId();
        $cartItems = \App\Models\CartItem::with('ticket')
            ->where('session_id', $sessionId)
            ->get();
        
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });
        
        return view('client.store.store', compact('tickets', 'cartTotal'));
    }

    public function ticketDetail($id)
    {
        $ticket = \App\Models\Ticket::findOrFail($id);
        $sessionId = request()->session()->getId();
        $cartItems = \App\Models\CartItem::with('ticket')
            ->where('session_id', $sessionId)
            ->get();
        
        $cartTotal = $cartItems->sum(function($item) {
            return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
        });
        
        return view('client.store.ticket_detail', compact('ticket', 'cartTotal'));
    }

    public function modularAsia()
    {
        $schedules = \App\Models\Schedule::where('event_type', 'modular_asia')
            ->orderBy('start_time')
            ->get();

        return view('client.modular-asia', compact('schedules'));
    }

    public function facilityManagement()
    {
        $schedules = Schedule::where('event_type', 'facility_management')
            ->orderByRaw('CAST(session AS UNSIGNED) ASC')
            ->orderBy('start_time')
            ->get();

        return view('client.facility-management', compact('schedules'));
    }

    public function nextgen()
    {
        return view('client.nextgen');
    }

    public function ibsHome()
    {
        return view('client.ibs-home');
    }

    public function careerSpotlight()
    {
        return view('client.career-spotlight');
    }

    public function podcast()
    {
        return view('client.podcast');
    }

    public function calendar()
    {
        $events = Event::where('is_published', true)
            ->orderBy('start_date', 'asc')
            ->get();
            
        return view('client.calendar', compact('events'));
    }

    public function terms()
    {
        return view('client.terms');
    }

    public function about()
    {
        return view('client.about');
    }

    public function gallery()
    {
        return view('client.gallery');
    }
}
