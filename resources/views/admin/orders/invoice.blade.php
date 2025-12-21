<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Dhawuh Bumi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-white p-8 max-w-3xl mx-auto font-sans text-slate-800">

    <div class="flex justify-between items-start border-b-2 border-slate-800 pb-6 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">INVOICE</h1>
            <p class="text-sm text-slate-500 mt-1">#{{ $order->id }}</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-[#4CAF50]">Dhawuh Bumi</h2>
            <p class="text-sm text-slate-600">Pusat Sayur Segar</p>
            <p class="text-sm text-slate-600">Banyumas, Jawa Tengah</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-8 mb-8">
        <div>
            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-500 mb-2">Penerima (Buyer)</h3>
            <p class="font-bold text-lg text-slate-800">{{ $order->user->name }}</p>
            <p class="text-slate-600 text-sm whitespace-pre-line">{{ $order->shipping_address_detail }}</p>
            <p class="text-slate-600 text-sm mt-1">HP: {{ $order->user->phone ?? '-' }}</p>
        </div>
        <div class="text-right">
            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-500 mb-2">Tanggal Order</h3>
            <p class="font-bold text-slate-800">{{ $order->created_at->format('d F Y') }}</p>
            <h3 class="font-bold text-xs uppercase tracking-wider text-slate-500 mt-4 mb-2">Status Pembayaran</h3>
            
            @if($order->payment_status == 'paid')
                <div class="inline-block border-2 border-emerald-600 text-emerald-600 font-black text-xl px-4 py-1 rounded transform -rotate-6">
                    LUNAS
                </div>
            @else
                <div class="inline-block border-2 border-red-500 text-red-500 font-bold text-lg px-3 py-1 rounded">
                    BELUM LUNAS
                </div>
            @endif
        </div>
    </div>

    <table class="w-full mb-8">
        <thead>
            <tr class="border-y border-slate-200">
                <th class="py-3 text-left font-bold text-slate-600 text-sm">Produk</th>
                <th class="py-3 text-center font-bold text-slate-600 text-sm">Qty</th>
                <th class="py-3 text-right font-bold text-slate-600 text-sm">Harga</th>
                <th class="py-3 text-right font-bold text-slate-600 text-sm">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($order->items as $item)
            <tr>
                <td class="py-3 text-left">
                    <p class="font-bold text-slate-800 text-sm">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                </td>
                <td class="py-3 text-center text-sm text-slate-600">
                    {{ $item->quantity }}
                </td>
                <td class="py-3 text-right text-sm text-slate-600">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </td>
                <td class="py-3 text-right font-bold text-slate-800 text-sm">
                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="border-t border-slate-200">
                <td colspan="3" class="pt-4 text-right text-sm text-slate-600">Subtotal</td>
                <td class="pt-4 text-right font-bold text-slate-800">Rp {{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="pt-2 text-right text-sm text-slate-600">Ongkos Kirim</td>
                <td class="pt-2 text-right font-bold text-slate-800">Rp {{ number_format($order->total_price - $order->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</td>
            </tr>
            <tr class="text-lg">
                <td colspan="3" class="pt-4 text-right font-black text-slate-900">GRAND TOTAL</td>
                <td class="pt-4 text-right font-black text-[#4CAF50]">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="border-t-2 border-slate-800 pt-6 mt-12 text-center text-xs text-slate-500">
        <p>Terima kasih telah berbelanja di Dhawuh Bumi!</p>
        <p class="mt-1">Invoice ini sah dan diproses otomatis oleh komputer.</p>
    </div>

    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()" class="bg-[#4CAF50] text-white px-6 py-3 rounded-full shadow-lg font-bold hover:bg-emerald-600 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Invoice
        </button>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>

</body>
</html>
