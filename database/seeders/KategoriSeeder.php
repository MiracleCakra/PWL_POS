<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriData = [
            [
                'kategori_kode' => 'PS',
                'kategori_nama' => 'Playstation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_kode' => 'BK',
                'kategori_nama' => 'Buku',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_kode' => 'NTD',
                'kategori_nama' => 'Nintendo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_kode' => 'MTR',
                'kategori_nama' => 'Motor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_kode' => 'DMD',
                'kategori_nama' => 'Diamond',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        
        DB::table('m_kategori')->insert($kategoriData);
    }
}
