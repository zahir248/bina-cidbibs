<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BillingDetail;
use App\Models\Order;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CommunityMembersExport;
use App\Exports\TicketPurchasersExport;
use App\Exports\ParticipantsExport;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Get admin users with pagination
        $adminQuery = (clone $query);
        if ($request->has('admin_search')) {
            $search = $request->admin_search;
            $adminQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $adminUsers = $adminQuery->where('role', 'admin')
            ->paginate(5, ['*'], 'admin_page');

        // Get client users with pagination
        $clientQuery = (clone $query);
        if ($request->has('client_search')) {
            $search = $request->client_search;
            $clientQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($q) use ($search) {
                      $q->where('mobile_number', 'like', "%{$search}%")
                        ->orWhere('organization', 'like', "%{$search}%")
                        ->orWhere('academic_institution', 'like', "%{$search}%");
                  });
            });
        }
        $clientUsers = $clientQuery->where('role', 'client')
            ->with('profile')
            ->paginate(5, ['*'], 'client_page');

        // Get ticket purchasers
        $purchaserQuery = BillingDetail::whereHas('orders', function($query) {
            $query->where('status', 'paid');
        });
        
        if ($request->has('purchaser_search')) {
            $search = $request->purchaser_search;
            $purchaserQuery->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }

        $ticketPurchasers = $purchaserQuery->with(['orders' => function($query) {
                $query->where('status', 'paid');
            }])
            ->latest()
            ->paginate(5, ['*'], 'purchaser_page');

        // Get all participants (real + virtual) without pagination first
        $allParticipants = collect();
        
        // Get real participants
        $realParticipants = Participant::query()
            ->with(['order.billingDetail', 'ticket'])
            ->get();
        $allParticipants = $allParticipants->merge($realParticipants);
        
        // Get orders with participants to identify which orders need purchaser fallback
        $ordersWithParticipants = Order::whereHas('participants')->pluck('id')->toArray();
        
        // Get orders without participants but with paid status
        $ordersWithoutParticipants = Order::where('status', 'paid')
            ->whereNotIn('id', $ordersWithParticipants)
            ->with(['billingDetail'])
            ->get();

        // Create virtual participants from purchaser data for orders without participants
        foreach ($ordersWithoutParticipants as $order) {
            foreach ($order->cart_items as $item) {
                $ticket = \App\Models\Ticket::find($item['ticket_id']);
                if (!$ticket) continue;
                
                $quantity = $item['quantity'];
                
                // For each ticket quantity, create a virtual participant
                for ($i = 0; $i < $quantity; $i++) {
                    // Only use purchaser data for the first ticket, leave others empty
                    if ($i === 0) {
                        $virtualParticipant = new \App\Models\Participant([
                            'id' => 'virtual_' . $order->id . '_' . $i,
                            'full_name' => $order->billingDetail->first_name . ' ' . $order->billingDetail->last_name,
                            'phone' => $order->billingDetail->phone,
                            'email' => $order->billingDetail->email,
                            'gender' => null,
                            'company_name' => $order->billingDetail->company_name,
                            'identity_number' => $order->billingDetail->identity_number,
                            'ticket_number' => null,
                        ]);
                        $virtualParticipant->order = $order;
                        $virtualParticipant->ticket = $ticket;
                        $virtualParticipant->is_virtual = true;
                        $allParticipants->push($virtualParticipant);
                    } else {
                        // Empty participant for additional tickets
                        $virtualParticipant = new \App\Models\Participant([
                            'id' => 'virtual_' . $order->id . '_' . $i,
                            'full_name' => '',
                            'phone' => '',
                            'email' => '',
                            'gender' => null,
                            'company_name' => '',
                            'identity_number' => '',
                            'ticket_number' => null,
                        ]);
                        $virtualParticipant->order = $order;
                        $virtualParticipant->ticket = $ticket;
                        $virtualParticipant->is_virtual = true;
                        $allParticipants->push($virtualParticipant);
                    }
                }
            }
        }
        
        // Apply search filter if needed
        if ($request->has('participant_search') && !empty($request->participant_search)) {
            $search = trim($request->participant_search);
            $beforeSearchCount = $allParticipants->count();
            
            $allParticipants = $allParticipants->filter(function($participant) use ($search) {
                // Handle null values safely
                $fullName = $participant->full_name ?? '';
                $email = $participant->email ?? '';
                $phone = $participant->phone ?? '';
                $companyName = $participant->company_name ?? '';
                $identityNumber = $participant->identity_number ?? '';
                
                $matches = stripos($fullName, $search) !== false ||
                          stripos($email, $search) !== false ||
                          stripos($phone, $search) !== false ||
                          stripos($companyName, $search) !== false ||
                          stripos($identityNumber, $search) !== false;
                
                return $matches;
            });
            
            $afterSearchCount = $allParticipants->count();
            \Log::info("Participant search: '{$search}' - Before: {$beforeSearchCount}, After: {$afterSearchCount}");
        }

        // Sort by latest (most recent orders first)
        $allParticipants = $allParticipants->sortByDesc(function($participant) {
            return $participant->order->created_at;
        });

        // Create pagination manually
        $perPage = 5;
        $currentPage = $request->get('participant_page', 1);
        $currentPageItems = $allParticipants->forPage($currentPage, $perPage);
        
        $participants = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $allParticipants->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'participant_page',
                'query' => $request->query()
            ]
        );

        return view('admin.users.index', compact('adminUsers', 'clientUsers', 'ticketPurchasers', 'participants'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Attempting to create new admin user', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            Log::info('Validation passed', ['validated_data' => $validated]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);

            Log::info('User created successfully', ['user_id' => $user->id]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create admin user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create admin user: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            ]);

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update admin user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->role !== 'admin') {
                return redirect()->back()
                    ->with('error', 'Only admin users can be deleted from this interface.');
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Admin user deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete admin user: ' . $e->getMessage());
        }
    }

    public function downloadCommunityMembers()
    {
        return Excel::download(new CommunityMembersExport, 'community-members-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadTicketPurchasers()
    {
        return Excel::download(new TicketPurchasersExport, 'ticket-purchasers-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadParticipants()
    {
        return Excel::download(new ParticipantsExport, 'participants-' . now()->format('Y-m-d') . '.xlsx');
    }
} 