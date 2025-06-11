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
        $sessionId = $request->session()->getId();
        $cartItems = CartItem::with('ticket')
            ->where('session_id', $sessionId)
            ->get();
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
                $cartItem = CartItem::where('session_id', $sessionId)
                    ->where('ticket_id', $ticketData['ticket_id'])
                    ->first();

                if ($cartItem) {
                    $cartItem->quantity += $ticketData['quantity'];
                    $cartItem->save();
                } else {
                    CartItem::create([
                        'session_id' => $sessionId,
                        'ticket_id' => $ticketData['ticket_id'],
                        'quantity' => $ticketData['quantity'],
                    ]);
                }
                $addedItems++;
            }

            // Calculate new cart total
            $cartItems = CartItem::with('ticket')
                ->where('session_id', $sessionId)
                ->get();
            
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
            $cartItem = CartItem::where('session_id', $sessionId)
                ->where('ticket_id', $request->ticket_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'session_id' => $sessionId,
                    'ticket_id' => $request->ticket_id,
                    'quantity' => $request->quantity,
                ]);
            }

            return redirect()->back()->with('success', 'Ticket added to cart!');
        }
    }

    // Remove item
    public function remove(Request $request, $id)
    {
        $sessionId = $request->session()->getId();
        $cartItem = CartItem::where('session_id', $sessionId)->where('id', $id)->firstOrFail();
        $cartItem->delete();
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
} 