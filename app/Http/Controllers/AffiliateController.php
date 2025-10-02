<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the user's affiliate links.
     */
    public function index()
    {
        $affiliates = Auth::user()->affiliates()->orderBy('created_at', 'desc')->get();
        return view('client.affiliate.index', compact('affiliates'));
    }

    /**
     * Show the form for creating a new affiliate link.
     */
    public function create()
    {
        return view('client.affiliate.create');
    }

    /**
     * Store a newly created affiliate link.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $affiliate = Affiliate::create([
            'user_id' => Auth::id(),
            'affiliate_code' => Affiliate::generateAffiliateCode(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('affiliate.index')
            ->with('success', 'Affiliate link created successfully!');
    }

    /**
     * Display the specified affiliate link.
     */
    public function show(Affiliate $affiliate)
    {
        // Ensure the affiliate belongs to the authenticated user
        if ($affiliate->user_id !== Auth::id()) {
            abort(403);
        }

        return view('client.affiliate.show', compact('affiliate'));
    }

    /**
     * Show the form for editing the specified affiliate link.
     */
    public function edit(Affiliate $affiliate)
    {
        // Ensure the affiliate belongs to the authenticated user
        if ($affiliate->user_id !== Auth::id()) {
            abort(403);
        }

        return view('client.affiliate.edit', compact('affiliate'));
    }

    /**
     * Update the specified affiliate link.
     */
    public function update(Request $request, Affiliate $affiliate)
    {
        // Ensure the affiliate belongs to the authenticated user
        if ($affiliate->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $affiliate->update($request->only(['name', 'description', 'is_active']));

        return redirect()->route('affiliate.index')
            ->with('success', 'Affiliate link updated successfully!');
    }

    /**
     * Remove the specified affiliate link.
     */
    public function destroy(Affiliate $affiliate)
    {
        // Ensure the affiliate belongs to the authenticated user
        if ($affiliate->user_id !== Auth::id()) {
            abort(403);
        }

        $affiliate->delete();

        return redirect()->route('affiliate.index')
            ->with('success', 'Affiliate link deleted successfully!');
    }

    /**
     * Track affiliate link clicks.
     */
    public function trackClick(Request $request)
    {
        $affiliateCode = $request->get('ref');
        
        if ($affiliateCode) {
            $affiliate = Affiliate::where('affiliate_code', $affiliateCode)
                ->where('is_active', true)
                ->first();
            
            if ($affiliate) {
                $affiliate->incrementClicks();
                
                // Store affiliate code in session for order tracking
                session(['affiliate_code' => $affiliateCode]);
            }
        }

        return redirect()->route('client.home');
    }
}