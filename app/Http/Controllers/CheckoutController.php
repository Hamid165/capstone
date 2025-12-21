<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingRate;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // Step 1: Shipping Detail Form
    public function shippingForm()
    {
        $cartItems = Auth::user()->cartItems;
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $cities = ShippingRate::orderBy('destination_city')->get();

        return view('checkout.shipping', compact('cartItems', 'cities'));
    }

    // Process Shipping Form -> Store in Session -> Redirect to Summary
    public function storeShipping(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_rate_id' => 'required|exists:shipping_rates,id',
            'shipping_address' => 'required|string',
        ]);

        // Store checkout data in session
        session([
            'checkout_data' => [
                'name' => $request->name,
                'phone' => $request->phone,
                'shipping_rate_id' => $request->shipping_rate_id,
                'shipping_address' => $request->shipping_address,
            ]
        ]);

        return redirect()->route('checkout.summary');
    }

    // Step 2: Order Summary (Display Items + Shipping Cost)
    public function summary()
    {
        $checkoutData = session('checkout_data');
        if (!$checkoutData) {
            return redirect()->route('checkout.shipping');
        }

        $cartItems = Auth::user()->cartItems;
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $shippingRate = ShippingRate::find($checkoutData['shipping_rate_id']);
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $total = $subtotal + $shippingRate->price;

        return view('checkout.summary', compact('cartItems', 'checkoutData', 'shippingRate', 'subtotal', 'total'));
    }

    // Step 3: Process Order (Create Record & Clear Cart)
    public function process()
    {
        $checkoutData = session('checkout_data');
        if (!$checkoutData) {
            return redirect()->route('checkout.shipping');
        }

        $cartItems = Auth::user()->cartItems;
        $shippingRate = ShippingRate::find($checkoutData['shipping_rate_id']);
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        try {
            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'shipping_status' => 'pending', // Correct column name
                'payment_status' => 'unpaid',
                'total_price' => $subtotal + $shippingRate->price,
                'shipping_address_detail' => $checkoutData['shipping_address'] . ', ' . $shippingRate->destination_city, // Correct column name
                'shipping_rate_id' => $shippingRate->id, // Add Relation
                // 'shipping_cost' => $shippingRate->price, // removed as not in schema, logic implied by shipping_rate_id or total_price
                'payment_method' => 'bank_transfer', // Default method, will be handled by Midtrans
            ]);

            // Create Order Items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            // --- MIDTRANS INTEGRATION ---
            // Set your Merchant Server Key
            Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            Config::$isProduction = config('midtrans.is_production');
            // Set sanitization on (default)
            Config::$isSanitized = config('midtrans.is_sanitized');
            // Set 3DS on (default)
            Config::$is3ds = config('midtrans.is_3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '',
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $order->snap_token = $snapToken;
                $order->save();
            } catch (\Exception $e) {
                // If Midtrans fails, we still save the order but maybe log error
                // For now, allow it to proceed, user can try paying later via Order History if we implement that
            }

            // Clear Cart
            Auth::user()->cartItems()->delete();
            
            // Clear Session
            session()->forget('checkout_data');

            DB::commit();

            // Redirect to Customer Order Detail Page for Payment
            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
