<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'm_supplier';  // definisi pada nama tabel
    protected $primaryKey = 'supplier_id';  // definisi primary key

    public $timestamps = true; // Aktifkan timestamps


    protected $fillable = ['supplier_id', 'nama_supplier', 'kontak', 'alamat'];
}
