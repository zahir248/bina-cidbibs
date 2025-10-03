<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    /**
     * Display a listing of all affiliate links.
     */
    public function index(Request $request)
    {
        $query = Affiliate::with('user')
            ->withCount('orders');

        // Apply search filters
        if ($request->has('search') && !empty($request->search)) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('affiliate_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }

        // Apply date range filters
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $affiliates = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.affiliate.index', compact('affiliates'));
    }

    /**
     * Display the specified affiliate link with detailed statistics.
     */
    public function show(Affiliate $affiliate)
    {
        $affiliate->load('user');
        
        // Get all orders from this affiliate with pagination
        $recentOrders = Order::where('affiliate_id', $affiliate->id)
            ->with('billingDetail')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Get monthly statistics
        $monthlyStats = Order::where('affiliate_id', $affiliate->id)
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        // Calculate total amount for all orders under this affiliate
        $totalAmount = Order::where('affiliate_id', $affiliate->id)
            ->sum('total_amount');

        // Calculate orders count for this affiliate
        $ordersCount = Order::where('affiliate_id', $affiliate->id)->count();

        return view('admin.affiliate.show', compact('affiliate', 'recentOrders', 'monthlyStats', 'totalAmount', 'ordersCount'));
    }

    /**
     * Show the form for creating a new affiliate.
     */
    public function create()
    {
        return view('admin.affiliate.create');
    }

    /**
     * Store a newly created affiliate.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Create affiliate for the logged-in admin user
        $affiliate = Affiliate::create([
            'user_id' => auth()->id(),
            'affiliate_code' => Affiliate::generateAffiliateCode(),
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => true,
            'total_clicks' => 0,
            'total_conversions' => 0,
        ]);

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate created successfully!');
    }

    /**
     * Show the form for editing the specified affiliate.
     */
    public function edit(Affiliate $affiliate)
    {
        $affiliate->load('user');
        return view('admin.affiliate.edit', compact('affiliate'));
    }

    /**
     * Update the specified affiliate.
     */
    public function update(Request $request, Affiliate $affiliate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $affiliate->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ]);

        return redirect()->route('admin.affiliates.index')
            ->with('success', 'Affiliate updated successfully!');
    }

    /**
     * Update affiliate status.
     */
    public function updateStatus(Request $request, Affiliate $affiliate)
    {
        // When checkbox is unchecked, it doesn't send any value, so default to false
        $isActive = $request->has('is_active') ? (bool) $request->is_active : false;

        $affiliate->update([
            'is_active' => $isActive
        ]);

        $status = $isActive ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Affiliate link {$status} successfully!");
    }

    /**
     * Get affiliate statistics for dashboard.
     */
    public function getStats()
    {
        $totalAffiliates = Affiliate::count();
        $activeAffiliates = Affiliate::where('is_active', true)->count();
        $totalClicks = Affiliate::sum('total_clicks');
        $totalConversions = Affiliate::sum('total_conversions');

        // Top performing affiliates
        $topAffiliates = Affiliate::with('user')
            ->orderBy('total_conversions', 'desc')
            ->limit(5)
            ->get();

        return [
            'total_affiliates' => $totalAffiliates,
            'active_affiliates' => $activeAffiliates,
            'total_clicks' => $totalClicks,
            'total_conversions' => $totalConversions,
            'top_affiliates' => $topAffiliates
        ];
    }

    /**
     * Export affiliate data to Excel.
     */
    public function export()
    {
        $affiliates = Affiliate::with('user')
            ->withCount('orders')
            ->get();

        // This would typically use Laravel Excel
        // For now, return a simple CSV response
        $filename = 'affiliates_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($affiliates) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'User Name',
                'User Email',
                'Affiliate Code',
                'Name',
                'Total Clicks',
                'Total Conversions',
                'Orders Count',
                'Status',
                'Created At'
            ]);

            // CSV data
            foreach ($affiliates as $affiliate) {
                fputcsv($file, [
                    $affiliate->id,
                    $affiliate->user->name ?? 'N/A',
                    $affiliate->user->email ?? 'N/A',
                    $affiliate->affiliate_code,
                    $affiliate->name ?? 'N/A',
                    $affiliate->total_clicks,
                    $affiliate->total_conversions,
                    $affiliate->orders_count,
                    $affiliate->is_active ? 'Active' : 'Inactive',
                    $affiliate->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}