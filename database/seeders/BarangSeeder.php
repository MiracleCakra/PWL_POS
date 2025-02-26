<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangData = [
            // PlayStation (PS)
            [
                'kategori_id' => 1,
                'barang_kode' => 'PS1',
                'barang_nama' => 'PlayStation 3',
                'harga_beli' => 1500000,
                'harga_jual' => 2000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'barang_kode' => 'PS2',
                'barang_nama' => 'PlayStation 5',
                'harga_beli' => 2000000,
                'harga_jual' => 2500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buku (BK)
            [
                'kategori_id' => 2,
                'barang_kode' => 'BK1',
                'barang_nama' => 'Dunia Shopie',
                'harga_beli' => 100000,
                'harga_jual' => 150000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'barang_kode' => 'BK2',
                'barang_nama' => 'Mein Kampf',
                'harga_beli' => 150000,
                'harga_jual' => 200000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Nintendo (NTD)
            [
                'kategori_id' => 3,
                'barang_kode' => 'NTD1',
                'barang_nama' => 'Nintendo Switch Lite',
                'harga_beli' => 5000000,
                'harga_jual' => 6000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 3,
                'barang_kode' => 'NTD2',
                'barang_nama' => 'Nintendo Switch Jailbreak',
                'harga_beli' => 7000000,
                'harga_jual' => 8000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Motor (MTR)
            [
                'kategori_id' => 4,
                'barang_kode' => 'MTR1',
                'barang_nama' => 'Suzuki GSX-R1000',
                'harga_beli' => 280000000,
                'harga_jual' => 300000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 4,
                'barang_kode' => 'MTR2',
                'barang_nama' => 'Cbr 1000rr',
                'harga_beli' => 1077000000,
                'harga_jual' => 1100000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Diamond (DMD)
            [
                'kategori_id' => 5,
                'barang_kode' => 'DMD1',
                'barang_nama' => 'White Diamond',
                'harga_beli' => 100000000,
                'harga_jual' => 120000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 5,
                'barang_kode' => 'DMD2',
                'barang_nama' => 'Black Diamond',
                'harga_beli' => 150000000,
                'harga_jual' => 180000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];


        DB::table('m_barang')->insert($barangData);
    }
}
