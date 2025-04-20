<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LevelModel;

class LevelController extends Controller
{
    public function index()
    {
        return LevelModel::all();
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'level_nama' => 'required|string|max:50',
        ]);

        // Perbaiki query menggunakan primary key yang benar
        $lastLevel = LevelModel::orderBy('level_id', 'desc')->first();

        // Tambahkan pengecekan untuk level_kode
        $newCode = 'LVL001';
        if ($lastLevel && isset($lastLevel->level_kode)) {
            $lastCode = substr($lastLevel->level_kode, 3);
            $nextNumber = is_numeric($lastCode) ? intval($lastCode) + 1 : 1;
            $newCode = 'LVL' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        }

        $level = LevelModel::create([
            'level_kode' => $newCode,
            'level_nama' => $validated['level_nama'],
        ]);

        return response()->json($level, 201);
    }
public function show(LevelModel $level)
{
    return $level; // $level sudah merupakan instance model
}

public function update(Request $request, LevelModel $level)
{
    $level->update($request->all());
    return $level; // Langsung kembalikan model yang sudah diupdate
}

public function destroy(LevelModel $level) // Diubah dari $user menjadi $level
{
    $level->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data terhapus',
    ]);
}
}
