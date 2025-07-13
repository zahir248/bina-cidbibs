<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; 
use App\Models\User;
use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function loginPage()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if user is admin or superadmin
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
            
            // If not admin or superadmin, logout and redirect back
            Auth::logout();
            return back()->withErrors([
                'email' => 'You do not have permission to access the admin area.',
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function dashboard()
    {
        // Get total community members (excluding admin and superadmin)
        $totalUsers = User::where('role', 'client')->count();

        // Get gender statistics from billing details
        $genderStats = DB::table('billing_details')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [ucfirst($item->gender) => $item->total];
            })
            ->toArray();

        // Get category statistics from billing details
        $categoryStats = DB::table('billing_details')
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [ucfirst($item->category) => $item->total];
            })
            ->toArray();

        // Get location statistics from billing details
        $locationStats = [
            'countries' => DB::table('billing_details')
                ->select('country', DB::raw('count(*) as total'))
                ->groupBy('country')
                ->orderByDesc('total')
                ->get(),
            'cities' => DB::table('billing_details')
                ->select('city', 'country', DB::raw('count(*) as total'))
                ->groupBy('city', 'country')
                ->orderByDesc('total')
                ->get()
        ];

        // Get total orders and calculate revenue
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')
            ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
            ->value('total');

        // Calculate success rate (percentage of paid orders)
        $successRate = $totalOrders > 0 
            ? (Order::where('status', 'paid')->count() / $totalOrders) * 100 
            : 0;

        // Get recent orders with billing details
        $recentOrders = Order::with('billingDetail')
            ->latest()
            ->take(5)
            ->get();

        // Get ticket statistics
        $totalTickets = Ticket::count();
        $lowStockTickets = Ticket::where('stock', '<', 10)->count();

        // Calculate revenue for today and this month
        $todayRevenue = Order::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
            ->value('total') ?? 0;

        $monthlyRevenue = Order::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw('SUM(total_amount - COALESCE(processing_fee, 0)) as total')
            ->value('total') ?? 0;

        // Calculate sold quantity for every ticket
        $tickets = \App\Models\Ticket::all();
        $ticketNames = [];
        $soldQuantities = [];
        $ticketRevenues = [];
        foreach ($tickets as $ticket) {
            $sold = \App\Models\Order::where('status', 'paid')
                ->get()
                ->sum(function($order) use ($ticket) {
                    $items = $order->cart_items;
                    $qty = 0;
                    foreach ($items as $item) {
                        if (isset($item['ticket_id']) && $item['ticket_id'] == $ticket->id) {
                            $qty += $item['quantity'];
                        }
                    }
                    return $qty;
                });
            $ticketNames[] = $ticket->name;
            $soldQuantities[] = $sold;

            // Calculate revenue for each ticket (using discounted price logic)
            $revenue = \App\Models\Order::where('status', 'paid')
                ->get()
                ->sum(function($order) use ($ticket) {
                    $items = $order->cart_items;
                    $amount = 0;
                    foreach ($items as $item) {
                        if (isset($item['ticket_id']) && $item['ticket_id'] == $ticket->id && isset($item['quantity'])) {
                            $quantity = (int)$item['quantity'];
                            // Determine the price to use (with discount if available)
                            $price = (float)$ticket->price;
                            if (!empty($ticket->quantity_discounts) && is_array($ticket->quantity_discounts)) {
                                foreach ($ticket->quantity_discounts as $discount) {
                                    $min = isset($discount['min']) ? $discount['min'] : null;
                                    $max = isset($discount['max']) ? $discount['max'] : null;
                                    if ($min !== null && $quantity >= $min && ($max === null || $quantity <= $max)) {
                                        $price = (float)$discount['price'];
                                        break;
                                    }
                                }
                            }
                            $amount += $quantity * $price;
                        }
                    }
                    return $amount;
                });
            $ticketRevenues[] = $revenue;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'successRate',
            'recentOrders',
            'totalTickets',
            'lowStockTickets',
            'todayRevenue',
            'monthlyRevenue',
            'ticketNames',
            'soldQuantities',
            'ticketRevenues',
            'genderStats',
            'categoryStats',
            'locationStats'
        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Handle GET requests to the logout route
     */
    public function handleGetLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('message', 'You have been logged out successfully.');
    }
}
