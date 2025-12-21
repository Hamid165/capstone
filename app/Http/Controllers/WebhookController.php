<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Notification;

class WebhookController extends Controller
{
    public function handler(Request $request)
    {
        // Set configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        try {
            DB::beginTransaction();

            $notif = new Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            $order = Order::findOrFail($orderId);

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

            DB::commit();
            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function markAsPaid(Order $order)
    {
        // Prevent double decrement
        if ($order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'shipping_status' => 'processing' // Auto move to processing if paid
            ]);

            // Decrease Stock
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }
        }
    }
}
