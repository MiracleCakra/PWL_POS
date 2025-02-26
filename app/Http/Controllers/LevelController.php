<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Command\WhereamiCommand;

class LevelController extends Controller
{
public function index()
{
    //Menambahkan 1 dara ke tabel m_level
   //DB::insert('insert into m_level(level_kode,level_nama,created_at) values(?,?,?)', ['CUS','Pelanggan',now()]);
    //return 'Insert Data baru berhasil';

    //update tabel
//     $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
// return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

    //menghapus data
    //   $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
    //   return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

    //menampilkan data yang ada pada tabel m_level
    $data = DB::select('select * from m_level');
    return view('level', ['data' => $data]);
    }
}
