<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        // Recommendations (Random 4 products)
        $recommendations = Product::inRandomOrder()->limit(4)->get();

        return view('cart.index', compact('cartItems', 'recommendations'));
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Ensure user owns the item
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }
}
