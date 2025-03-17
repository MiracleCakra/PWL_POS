<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier'
        ];

        $activeMenu = 'supplier';

        $supplier = SupplierModel::select('supplier_id', 'nama_supplier', 'kontak', 'alamat')->distinct()->get();

        return view('supplier.index', compact('breadcrumb', 'page', 'activeMenu', 'supplier'));
    }

    public function list(Request $request)
    {
        $supplier = SupplierModel::select('supplier_id', 'nama_supplier', 'kontak', 'alamat', 'created_at', 'updated_at');

        if (!empty($request->nama_supplier)) {
            $supplier->where('nama_supplier', 'like', "%{$request->nama_supplier}%");
        }

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>' .
                    '</form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.supplierCreate', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255'
        ]);

        SupplierModel::create($request->only('nama_supplier', 'kontak', 'alamat'));

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show($supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);

        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.supplierShow', compact('supplier', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function edit($supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);

        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan.');
        }

        return view('supplier.supplierEdit', [
            'breadcrumb' => (object) ['title' => 'Edit Supplier', 'list' => ['Home', 'Supplier', 'Edit']],
            'page' => (object) ['title' => 'Edit Supplier'],
            'supplier' => $supplier,
            'activeMenu' => 'supplier'
        ]);
    }

    public function update(Request $request, $supplier_id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kontak' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255'
        ]);

        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan.');
        }

        $supplier->update($request->only('nama_supplier', 'kontak', 'alamat'));

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function destroy($supplier_id)
    {
        $supplier = SupplierModel::find($supplier_id);
        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            $supplier->delete();
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier sedang digunakan');
        }
    }
}
