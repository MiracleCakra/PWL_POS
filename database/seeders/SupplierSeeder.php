<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['nama_supplier' => 'PlayStation Hub', 'kontak' => '081234567890', 'alamat' => 'Jl. Sudirman No. 10, Jakarta'],
            ['nama_supplier' => 'Buku Indah', 'kontak' => '081345678901', 'alamat' => 'Jl. Asia Afrika No. 15, Bandung'],
            ['nama_supplier' => 'Nintendo Center', 'kontak' => '081456789012', 'alamat' => 'Jl. Pemuda No. 5, Surabaya'],
            ['nama_supplier' => 'Motor Jaya', 'kontak' => '081567890123', 'alamat' => 'Jl. Gatot Subroto No. 20, Medan'],
            ['nama_supplier' => 'Diamond Store', 'kontak' => '081678901234', 'alamat' => 'Jl. Pahlawan No. 3, Semarang'],
            ['nama_supplier' => 'Mobil Sejahtera', 'kontak' => '081789012345', 'alamat' => 'Jl. Malioboro No. 7, Yogyakarta'],
            ['nama_supplier' => 'PlayStation Arena', 'kontak' => '081890123456', 'alamat' => 'Jl. Thamrin No. 8, Jakarta'],
            ['nama_supplier' => 'Buku Cerdas', 'kontak' => '081901234567', 'alamat' => 'Jl. Diponegoro No. 12, Bandung'],
            ['nama_supplier' => 'Nintendo World', 'kontak' => '081012345678', 'alamat' => 'Jl. Ahmad Yani No. 6, Surabaya'],
            ['nama_supplier' => 'Motor Sehat', 'kontak' => '082123456789', 'alamat' => 'Jl. Cendrawasih No. 14, Medan'],
            ['nama_supplier' => 'Diamond Exclusive', 'kontak' => '082234567890', 'alamat' => 'Jl. Rajawali No. 11, Semarang'],
            ['nama_supplier' => 'Mobil Makmur', 'kontak' => '082345678901', 'alamat' => 'Jl. Sisingamangaraja No. 9, Yogyakarta'],
            ['nama_supplier' => 'PlayStation Ultimate', 'kontak' => '082456789012', 'alamat' => 'Jl. Jenderal Sudirman No. 21, Jakarta'],
            ['nama_supplier' => 'Buku Pintar', 'kontak' => '082567890123', 'alamat' => 'Jl. Braga No. 4, Bandung'],
            ['nama_supplier' => 'Nintendo Planet', 'kontak' => '082678901234', 'alamat' => 'Jl. Merdeka No. 17, Surabaya'],
            ['nama_supplier' => 'Motor Perkasa', 'kontak' => '082789012345', 'alamat' => 'Jl. Sudirman No. 10, Medan'],
            ['nama_supplier' => 'Diamond Prime', 'kontak' => '082890123456', 'alamat' => 'Jl. Diponegoro No. 22, Semarang'],
            ['nama_supplier' => 'Mobil Berkah', 'kontak' => '082901234567', 'alamat' => 'Jl. Sultan Agung No. 15, Yogyakarta'],
            ['nama_supplier' => 'PlayStation Store', 'kontak' => '083012345678', 'alamat' => 'Jl. Veteran No. 19, Jakarta'],
            ['nama_supplier' => 'Buku Kreatif', 'kontak' => '083123456789', 'alamat' => 'Jl. Ahmad Yani No. 23, Bandung'],
        ];

        DB::table('m_supplier')->insert($suppliers);
    }
}
