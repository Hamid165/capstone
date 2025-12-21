<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rates = [
            ['destination_city' => 'Kabupaten Banyumas', 'price' => 5000],
            ['destination_city' => 'Kabupaten Purbalingga', 'price' => 5000],
            ['destination_city' => 'Kabupaten Cilacap', 'price' => 7500],
            ['destination_city' => 'Kabupaten Tegal', 'price' => 7500],
            ['destination_city' => 'Kabupaten Banjarnegara', 'price' => 7500],
            ['destination_city' => 'Kabupaten Kebumen', 'price' => 10000],
            ['destination_city' => 'Kabupaten Pemalang', 'price' => 10000],
            ['destination_city' => 'Kota Tegal', 'price' => 10000],
            ['destination_city' => 'Kabupaten Brebes', 'price' => 10000],
            ['destination_city' => 'Kabupaten Wonosobo', 'price' => 10000],
            ['destination_city' => 'Kota Pekalongan', 'price' => 12500],
            ['destination_city' => 'Kabupaten Pekalongan', 'price' => 12500],
            ['destination_city' => 'Kabupaten Batang', 'price' => 12500],
            ['destination_city' => 'Kabupaten Purworejo', 'price' => 12500],
            ['destination_city' => 'Kabupaten Temanggung', 'price' => 15000],
            ['destination_city' => 'Kota Magelang', 'price' => 15000],
            ['destination_city' => 'Kabupaten Magelang', 'price' => 15000],
            ['destination_city' => 'Kabupaten Kendal', 'price' => 15000],
            ['destination_city' => 'Kabupaten Semarang', 'price' => 15000],
            ['destination_city' => 'Kota Semarang', 'price' => 15000],
            ['destination_city' => 'Kota Salatiga', 'price' => 15000],
            ['destination_city' => 'Kabupaten Boyolali', 'price' => 15000],
            ['destination_city' => 'Kabupaten Klaten', 'price' => 15000],
            ['destination_city' => 'Kabupaten Demak', 'price' => 15000],
            ['destination_city' => 'Kota Surakarta', 'price' => 15000],
            ['destination_city' => 'Kabupaten Sukoharjo', 'price' => 15000],
            ['destination_city' => 'Kabupaten Jepara', 'price' => 15000],
            ['destination_city' => 'Kabupaten Karanganyar', 'price' => 15000],
            ['destination_city' => 'Kabupaten Kudus', 'price' => 15000],
            ['destination_city' => 'Kabupaten Wonogiri', 'price' => 15000],
            ['destination_city' => 'Kabupaten Grobogan', 'price' => 15000],
            ['destination_city' => 'Kabupaten Sragen', 'price' => 15000],
            ['destination_city' => 'Kabupaten Pati', 'price' => 15000],
            ['destination_city' => 'Kabupaten Blora', 'price' => 15000],
            ['destination_city' => 'Kabupaten Rembang', 'price' => 15000],
        ];

        DB::table('shipping_rates')->insert($rates);
    }
}
