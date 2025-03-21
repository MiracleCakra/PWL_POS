<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use hasFactory;
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    //protected $fillable = ['barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'stok'];

    protected $fillable = [
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'kategori_id'
    ];
    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
