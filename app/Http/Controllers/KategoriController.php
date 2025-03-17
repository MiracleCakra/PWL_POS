<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    // melihat halaman daftar kategori
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama')->get();

        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategori' => $kategori
        ]);
    }

    // pengambilan daftar kategori dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama', 'created_at', 'updated_at');

        // menambah filter dengan kategori_kode
        if (!empty($request->kategori_kode)) {
            $kategori->where('kategori_kode', $request->kategori_kode);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                    . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    // melihat halaman form tambah kategori
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori';

        return view('kategori.kategoriCreate', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    //simpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    // melihat detail kategori
    public function show($kategori_id)
    {
        $kategori = KategoriModel::find($kategori_id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.kategoriShow', [
            'kategori' => $kategori,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // melihat halaman form edit kategori
    public function edit($id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return redirect('kategori')->with('error', 'Data kategori tidak ditemukan.');
        }

        $kategoriList = KategoriModel::all();

        return view('kategori.kategoriEdit', [
            'breadcrumb' => (object) ['title' => 'Edit Kategori', 'list' => ['Home', 'Kategori', 'Edit']],
            'page' => (object) ['title' => 'Edit Kategori'],
            'kategori' => $kategori,
            'kategoriList' => $kategoriList,
            'activeMenu' => 'kategori'
        ]);
    }

    // simpan perubahan data kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    // hapus data kategori
    public function destroy($id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori sedang digunakan');
        }
    }
}
