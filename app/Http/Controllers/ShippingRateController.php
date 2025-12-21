<?php

namespace App\Http\Controllers;

use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $rates = ShippingRate::all(); // Menampilkan semua data tarif ongkir
        return view('admin.shipping.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination_city' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        ShippingRate::create($request->all());

        return redirect()->back()->with('success', 'Tarif ongkir berhasil ditambahkan');
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $shippingRate->update([
            'price' => $request->price
        ]);

        return redirect()->back()->with('success', 'Harga ongkir berhasil diperbarui');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();
        return redirect()->back()->with('success', 'Tarif ongkir dihapus');
    }
}
