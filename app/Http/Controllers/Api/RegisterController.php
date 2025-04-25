<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'nama' => 'required',
            'password' => 'required',
            'level_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle image upload
        $image = $request->file('image');

        //menyimpan ke dalam direktori public/posts
        if (!file_exists(public_path('storage/posts'))) {
            mkdir(public_path('storage/posts'), 0777, true);
        }

        // menyimpan gambar
        $image->storeAs('public/posts', $image->hashName());

        //create user
        $user = UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'image' => $image->hashName(),
        ]);

        //return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        }

        //return JSON process failed
        return response()->json([
            'success' => false,
            'message' => 'Gagal menambahkan user'
        ], 409);
    }
}
