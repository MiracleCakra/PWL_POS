<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'Pembeli' => 'Cakra',
                'penjualan_kode' => 'PJ1',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'Pembeli' => 'Galung',
                'penjualan_kode' => 'PJ2',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'Pembeli' => 'Fajar',
                'penjualan_kode' => 'PJ3',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'Pembeli' => 'Rafi',
                'penjualan_kode' => 'PJ4',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'Pembeli' => 'Rizal',
                'penjualan_kode' => 'PJ5',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'Pembeli' => 'Naditya',
                'penjualan_kode' => 'PJ6',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'Pembeli' => 'Syahrul',
                'penjualan_kode' => 'PJ7',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'Pembeli' => 'Varizky',
                'penjualan_kode' => 'PJ8',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'Pembeli' => 'Arieya',
                'penjualan_kode' => 'PJ9',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'Pembeli' => 'Mila',
                'penjualan_kode' => 'PJ10',
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
