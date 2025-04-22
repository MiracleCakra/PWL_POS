<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // // Ambil data user dalam bentuk JSON untuk DataTables
    // public function list(Request $request)
    // {
    //     $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
    //         ->with('level');

    //     //filter data user berdasarkan level_id
    //     if ($request->level_id) {
    //         $users->where('level_id', $request->level_id);
    //     }

    //     return DataTables::of($users)
    //         // Menambahkan kolom index / nomor urut (default nama kolom: DT RowIndex)
    //         ->addIndexColumn()
    //         ->addColumn('aksi', function ($user) { // Menambahkan kolom aksi
    //             $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
    //                 . csrf_field()
    //                 . method_field('DELETE')
    //                 . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
    //                 . '</form>';
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
    //         ->make(true);
    // }


    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username', // Username harus unik, minimal 3 karakter
            'nama' => 'required|string|max:100', // Nama wajib diisi dengan maksimal 100 karakter
            'password' => 'required|min:5', // Password minimal 5 karakter
            'level_id' => 'required|integer' // Level ID harus berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), // Mengenkripsi password sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show($id)
    {
        $user = UserModel::with('level')->find($id);

        if (!$user) {
            return redirect('/user')->with('error', 'User tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user'; // Set menu yang sedang aktif

        return view('user.show', [
            'user' => $user,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            "title" => "Edit User",
            "list" => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            "title" => "Edit user"
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel user kolom username kecuali untuk user dengan id yang sedang diedit
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {      //untuk mengecek apakah data user yang akan dihapus ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            Usermodel::destroy($id);
            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, maka tampilkan pesan error dan redirect ke halaman user
            return redirect('/user')->with('error', 'Data user sedang digunakan');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')->with('level', $level);

    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default: DT_RowIndex)
            ->addColumn('aksi', function ($user) {
                $btn = '<a href="' . url('/user/' . $user->user_id . '/show') . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    //Menampilkan halaman form edit user ajax
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', [
            'user' => $user,
            'level' => $level
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Cek apakah user ada
            $user = UserModel::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            // Aturan validasi
            $rules = [
                'level_id' => ['required', 'integer'],
                'nama' => ['required', 'max:100'],
                'password' => ['nullable', 'min:6', 'max:20']
            ];

            // Validasi unique hanya jika username berubah
            if ($request->username !== $user->username) {
                $rules['username'] = [
                    'required',
                    'max:20',
                    Rule::unique('m_user', 'username')
                ];
            } else {
                $rules['username'] = ['required', 'max:20'];
            }

            // Validasi data
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Siapkan data yang akan diupdate
            $dataUpdate = $request->only(['level_id', 'username', 'nama']);

            // Jika password diisi, hash dan tambahkan ke update
            if ($request->filled('password')) {
                $dataUpdate['password'] = Hash::make($request->password);
            }

            // Lakukan update
            $user->update($dataUpdate);

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil diupdate'
            ]);
        }

        return redirect('/user');
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', [
            'user' => $user
        ]);
    }
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/window');
    }

    public function import()
    {
        return view('user.importUser');
    }

    //import ajax
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');  // ambil file dari request

            $reader = IOFactory::createReader('Xlsx');  // load reader file excel
            $reader->setReadDataOnly(true);             // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true);   // ambil data excel   // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => bcrypt($value['D']),
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    userModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/user');
    }

    //fungsi export
    public function export_excel()
    {
        //ambil data user
        $user = UserModel::select(
            'user_id',
            'level_id',
            'username',
            'nama',
            'password',
        )
            ->orderBy('user_id')
            ->with('level')
            ->get();

        //load excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        //set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID User');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Nama User');
        $sheet->setCellValue('E1', 'Password');
        $sheet->setCellValue('F1', 'Level');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); ///bold header

        // looping data dari database
        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->user_id);
            $sheet->setCellValue('C'.$baris, $value->username);
            $sheet->setCellValue('D'.$baris, $value->nama);
            $sheet->setCellValue('E'.$baris, $value->password);
            $sheet->setCellValue('F'.$baris, $value->level->level_nama); // ambil nama level
            $baris++;
            $no++;
        }


        //set lebar kolom
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set autosize
        }

        //set judul file
        $sheet->setTitle('Data User'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date(format: 'Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;

    } // end function export_excel

        // fungsi export pdf
        public function export_pdf()
        {
            $user = UserModel::orderBy('user_id')
                ->orderBy('level_id')
                ->with('level')
                ->get();

            //gunakan barryvdh dompdf
            $pdf = PDF::loadview('user.export_pdf', ['user' => $user]);
            $pdf->setPaper('a4', 'landscape');
            $pdf->setOption("isRemoteEnabled", true);
            $pdf->render();

            return $pdf->stream('Data user ' . date('Y-m-d H:i:s') . '.pdf');
        }
}
