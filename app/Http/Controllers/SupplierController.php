<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem',
        ];

        $activeMenu = 'supplier'; // untuk set menu yang sedang aktif

        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list()
    {
        $suppliers = SupplierModel::select('supplier_id', 'nama_supplier','kontak', 'alamat');

        return DataTables::of($suppliers)->addIndexColumn()->addColumn('aksi', function ($supplier) {

            $btn  = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn;
        })->rawColumns(['aksi'])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru',
        ];

        $activeMenu = 'supplier'; // untuk set menu yang sedang aktif

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'    => 'required|integer|unique:m_supplier,supplier_id',
            'nama_supplier'  => 'required|string|max:100',
            'kontak'         => 'required|string|max:20',
            'alamat'         => 'required|string|max:255',
        ]);

        SupplierModel::create($request->only(['supplier_id', 'nama_supplier', 'kontak', 'alamat']));

        return redirect('/supplier')->with('success', 'Data supplier berhasil ditambahkan!');
    }


    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id'    => 'required|integer|unique:m_supplier,supplier_id',
                'nama_supplier'  => 'required|string|max:100',
                'kontak'         => 'required|string|max:20',
                'alamat'         => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Validasi Gagal',
                    'errors'  => $validator->errors(), // Perbaikan: gunakan 'errors' bukan 'msgField'
                ]);
            }

            $supplier = SupplierModel::create($request->only(['supplier_id', 'nama_supplier', 'kontak', 'alamat']));

            return response()->json([
                'status'  => true,
                'message' => 'Data supplier berhasil disimpan',
                'data'    => $supplier, // Perbaikan: Kirim data supplier yang berhasil disimpan
            ]);
        }
        return redirect('/supplier');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail supplier',
        ];

        $activeMenu = 'supplier'; // untuk set menu yang sedang aktif

        $supplier = SupplierModel::find($id);

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.show_ajax', ['supplier' => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit supplier',
        ];

        $activeMenu = 'supplier'; // untuk set menu yang sedang aktif

        $supplier = SupplierModel::find($id);

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'nama_supplier' => 'required|string|max:100',
        'kontak'        => 'required|string|max:20',
        'alamat'        => 'required|string|max:255',
    ]);

    $supplier = SupplierModel::find($id);
    if (!$supplier) {
        return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan!');
    }

    $supplier->update([
        'nama_supplier' => $request->nama_supplier,
        'kontak'        => $request->kontak,
        'alamat'        => $request->alamat,
    ]);

    return redirect('/supplier')->with('success', 'Data supplier berhasil diubah!');
}

public function edit_ajax(string $id)
{
    $supplier = SupplierModel::find($id);
    return view('supplier.edit_ajax', ['supplier' => $supplier]);
}

public function update_ajax(Request $request, string $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'nama_supplier' => 'required|string|max:100',
            'kontak'        => 'required|string|max:20',
            'alamat'        => 'required|string|max:255',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi Gagal',
                'errors'  => $validator->errors(),
            ]);
        }

        $supplier = SupplierModel::find($id);
        if (!$supplier) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        $supplier->update($request->only(['nama_supplier', 'kontak', 'alamat']));

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil diupdate',
            'data'    => $supplier,
        ]);
    }

    return redirect('/supplier');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);

        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan!');
        }

        try {
            SupplierModel::destroy($id);

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini!');
        }
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
{
    try {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([
            'status'  => false,
            'message' => 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait',
        ]);
    }
    return redirect('/supplier');
    }
}
