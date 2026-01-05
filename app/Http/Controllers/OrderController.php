<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Transaction;

class OrderController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function index(Request $request)
    {
        $query = \App\Models\Order::with(['user', 'items.product']);

        // Filter Status
        if ($request->has('status') && $request->status != 'all' && $request->status != '') {
            $query->where('shipping_status', $request->status);
        }

        // Search by Order ID or User Name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        // Auto-check status if pending
        if ($order->payment_status == 'unpaid' || $order->payment_status == 'pending') {
            $this->checkMidtransStatus($order);
        }

        $order->load(['user', 'items.product', 'shippingRate']);
        return view('admin.orders.show', compact('order'));
    }

    // Customer View Order
    public function indexCustomer()
    {
        $orders = \App\Models\Order::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    public function showCustomer(\App\Models\Order $order)
    {
        // Ensure user owns the order
        if ($order->user_id != \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        // Auto-check status if pending
        if ($order->payment_status == 'unpaid' || $order->payment_status == 'pending') {
            $this->checkMidtransStatus($order);
        }
        
        // Ensure Snap Token exists (Self-healing)
        if ($order->payment_status == 'unpaid' && empty($order->snap_token)) {
            $this->generateSnapToken($order);
        }

        $order->load(['items.product', 'shippingRate']);
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, \App\Models\Order $order)
    {
        $request->validate([
            'shipping_status' => 'required|in:pending,processing,shipped,completed',
            'resi_number' => 'nullable|string'
        ]);

        $order->shipping_status = $request->shipping_status;

        // Jika status dikirim, wajib isi resi (validasi sederhana)
        if ($request->shipping_status == 'shipped' && $request->resi_number) {
            $order->resi_number = $request->resi_number;
            $order->payment_status = 'paid'; // Asumsi jika dikirim berarti sudah paid
        }

        // Jika status selesai, set paid
        if ($request->shipping_status == 'completed') {
            $order->payment_status = 'paid';
        }
        
        // Pura-pura "Processing" juga menandakan Paid jika dari Midtrans (Manual override for Admin)
        if ($request->shipping_status == 'processing') {
             $order->payment_status = 'paid';
        }

        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function print(\App\Models\Order $order)
    {
        $order->load(['user', 'items.product', 'shippingRate']);
        return view('admin.orders.invoice', compact('order'));
    }

    private function checkMidtransStatus($order)
    {
        try {
            $status = Transaction::status($order->id);
            $transaction = $status->transaction_status;
            $type = $status->payment_type;
            $fraud = $status->fraud_status;

            \Illuminate\Support\Facades\Log::info("Midtrans Check for Order #{$order->id}: Transaction Status = {$transaction}");

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $this->markAsPaid($order);
                    }
                }
            } else if ($transaction == 'settlement') {
                $this->markAsPaid($order);
            } else if ($transaction == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transaction == 'deny') {
                $order->update(['payment_status' => 'failed']);
            } else if ($transaction == 'expire') {
                $order->update(['payment_status' => 'failed']);
            } else if ($transaction == 'cancel') {
                $order->update(['payment_status' => 'failed']);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Midtrans Check Error: " . $e->getMessage());
        }
    }

    private function markAsPaid($order)
    {
        if ($order->payment_status !== 'paid') {
            \Illuminate\Support\Facades\Log::info("Marking Order #{$order->id} as Paid. Decrementing stock...");
            
            $order->update([
                'payment_status' => 'paid',
                'shipping_status' => 'processing'
            ]);

            // Decrease Stock
            foreach ($order->items as $item) {
                $product = $item->product; // Use relation directly
                if ($product) {
                    $newStock = $product->stock - $item->quantity;
                    \Illuminate\Support\Facades\Log::info("Product {$product->name}: Stock {$product->stock} -> {$newStock}");
                    $product->decrement('stock', $item->quantity);
                }
            }
        }
    }

    private function generateSnapToken($order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '',
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to generate Snap Token for Order #{$order->id}: " . $e->getMessage());
        }
    }
}
