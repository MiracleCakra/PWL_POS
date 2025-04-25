<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = BarangModel::with('kategori')->get();
        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|unique:m_barang',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle file upload
        $image = $request->file('image');

        // Pastikan direktori public/barang ada
        $path = public_path('storage/barang');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        // Simpan gambar
        $image->storeAs('public/barang', $image->hashName());

        // Create barang with image
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image' => $image->hashName(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $barang
        ], 201);
    }

    public function show($id)
    {
        $barang = BarangModel::with('kategori')->find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Data untuk update
        $data = [
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
        ];

        // Jika ada file image baru
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($barang->image) {
                Storage::delete('public/barang/' . $barang->getRawOriginal('image'));
            }

            // Upload image baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/barang', $imageName);

            // Tambahkan image ke data yang akan diupdate
            $data['image'] = $imageName;
        }

        $barang->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $barang
        ]);
    }

    public function destroy($id)
    {
        $barang = BarangModel::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus file image jika ada
        if ($barang->image) {
            Storage::delete('public/barang/' . $barang->getRawOriginal('image'));
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
