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
    $level = LevelModel::create($request->all());
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
