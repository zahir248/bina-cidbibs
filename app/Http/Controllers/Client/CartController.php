<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Ticket;

class CartController extends Controller
{
    // View cart
    public function index(Request $request)
    {
        $query = CartItem::with('ticket');
        
        if (auth()->check()) {
            // If user is logged in, get items by user_id or session_id
            $query->where(function($q) use ($request) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $request->session()->getId());
            });
        } else {
            // If user is not logged in, get items by session_id only
            $query->where('session_id', $request->session()->getId());
        }
        
        $cartItems = $query->get();
        return view('client.store.cart', compact('cartItems'));
    }

    // Add ticket to cart
    public function add(Request $request)
    {
        // Check if it's a bulk add from store page or single add from detail page
        if ($request->has('tickets')) {
            // Bulk add validation
            $request->validate([
                'tickets' => 'required|array',
                'tickets.*.ticket_id' => 'required|exists:tickets,id',
                'tickets.*.quantity' => 'required|integer|min:1',
            ]);

            $sessionId = $request->session()->getId();
            $addedItems = 0;

            foreach ($request->tickets as $ticketData) {
                // Check stock availability
                $ticket = \App\Models\Ticket::find($ticketData['ticket_id']);
                if (!$ticket->hasEnoughStock($ticketData['quantity'])) {
                    return response()->json([
                        'success' => false,
                        'message' => "Sorry, there are only {$ticket->stock} tickets available for {$ticket->name}."
                    ]);
                }

                $query = CartItem::query();
                
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', $sessionId);
                }
                
                $cartItem = $query->where('ticket_id', $ticketData['ticket_id'])->first();

                if ($cartItem) {
                    $cartItem->quantity += $ticketData['quantity'];
                    $cartItem->save();
                } else {
                    $cartData = [
                        'session_id' => $sessionId,
                        'ticket_id' => $ticketData['ticket_id'],
                        'quantity' => $ticketData['quantity'],
                    ];
                    
                    if (auth()->check()) {
                        $cartData['user_id'] = auth()->id();
                    }
                    
                    CartItem::create($cartData);
                }
                $addedItems++;
            }

            // Calculate new cart total
            $query = CartItem::with('ticket');
            
            if (auth()->check()) {
                $query->where(function($q) use ($sessionId) {
                    $q->where('user_id', auth()->id())
                      ->orWhere('session_id', $sessionId);
                });
            } else {
                $query->where('session_id', $sessionId);
            }
            
            $cartItems = $query->get();
            
            $cartTotal = $cartItems->sum(function($item) {
                return $item->ticket->getDiscountedPrice($item->quantity) * $item->quantity;
            });

            return response()->json([
                'success' => true,
                'message' => $addedItems . ' item(s) added to cart successfully!',
                'cartTotal' => $cartTotal
            ]);
        } else {
            // Single ticket validation (for detail page)
            $request->validate([
                'ticket_id' => 'required|exists:tickets,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $sessionId = $request->session()->getId();
            
            $query = CartItem::query();
            
            if (auth()->check()) {
                $query->where('user_id', auth()->id());
            } else {
                $query->where('session_id', $sessionId);
            }
            
            $cartItem = $query->where('ticket_id', $request->ticket_id)->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                $cartData = [
                    'session_id' => $sessionId,
                    'ticket_id' => $request->ticket_id,
                    'quantity' => $request->quantity,
                ];
                
                if (auth()->check()) {
                    $cartData['user_id'] = auth()->id();
                }
                
                CartItem::create($cartData);
            }

            return redirect()->back()->with('success', 'Ticket added to cart!');
        }
    }

    // Remove item
    public function remove(Request $request, $id)
    {
        $query = CartItem::query();
        
        if (auth()->check()) {
            $query->where(function($q) use ($request) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $request->session()->getId());
            });
        } else {
            $query->where('session_id', $request->session()->getId());
        }
        
        $cartItem = $query->where('id', $id)->firstOrFail();
        $cartItem->delete();
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    // Update item quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $query = CartItem::with('ticket');
        
        if (auth()->check()) {
            $query->where(function($q) use ($request) {
                $q->where('user_id', auth()->id())
                  ->orWhere('session_id', $request->session()->getId());
            });
        } else {
            $query->where('session_id', $request->session()->getId());
        }
        
        $cartItem = $query->where('id', $id)->firstOrFail();
        
        // Only check stock availability if increasing quantity
        if ($request->quantity > $cartItem->quantity) {
            if (!$cartItem->ticket->hasEnoughStock($request->quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => "Sorry, there are only {$cartItem->ticket->stock} tickets available for {$cartItem->ticket->name}."
                ]);
            }
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully!'
        ]);
    }
} 