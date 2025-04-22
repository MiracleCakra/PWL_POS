<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;


class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];

        $activeMenu = 'supplier';

        return view('supplier.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'kontak' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
        ]);

        SupplierModel::create([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function show($id)
    {
        $supplier = SupplierModel::find($id);

        if (!$supplier) {
            return redirect('/supplier')->with('error', 'Supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.supplierShow', [
            'supplier' => $supplier,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            "title" => "Edit Supplier",
            "list" => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            "title" => "Edit supplier"
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:100',
            'kontak' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
        ]);

        SupplierModel::find($id)->update([
            'nama_supplier' => $request->nama_supplier,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }
        try {
            SupplierModel::destroy($id);
            return redirect('/supplier')->with('  ', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier sedang digunakan');
        }
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_supplier' => 'required|string|max:100',
                'kontak' => 'required|string|max:50',
                'alamat' => 'required|string|max:200'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            SupplierModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan'
            ]);
        }
        return redirect('/supplier');
    }

    public function list(Request $request)
    {
        $supplier = SupplierModel::select('supplier_id', 'nama_supplier', 'kontak', 'alamat');

        return DataTables::of($supplier)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) {
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id . '/show') . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.edit_ajax', [
            'supplier' => $supplier
        ]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Cari data sup[lier
            $supplier = SupplierModel::find($id);
            if (!$supplier) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }

            // Aturan validasi
            $rules = [
                'kontak' => ['required', 'string', 'max:50'],
                'alamat' => ['required', 'string', 'max:200']
            ];

            // Validasi nama_supplier unik hanya jika diubah
            if ($request->nama_supplier !== $supplier->nama_supplier) {
                $rules['nama_supplier'] = [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('m_supplier', 'nama_supplier')
                ];
            } else {
                $rules['nama_supplier'] = ['required', 'string', 'max:100'];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            // Update data
            $supplier->update($request->only(['nama_supplier', 'kontak', 'alamat']));

            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil diupdate'
            ]);
        }

        return redirect('/supplier');
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', [
            'supplier' => $supplier
        ]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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
        return redirect('/supplier');
    }

    public function import()
    {
        return view('supplier.importSupplier');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_supplier');

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();

            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1 && (!empty($value['A']) || !empty($value['B']) || !empty($value['C']))) {
                        $insert[] = [
                            'nama_supplier' => $value['A'],
                            'kontak' => $value['B'],
                            'alamat' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    SupplierModel::insertOrIgnore($insert);
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
        return redirect('/supplier');
    }

    //fungsi export
    public function export_excel()
    {
        //ambil data supplier
        $supplier = SupplierModel::select(
            'supplier_id',
            'nama_supplier',
            'kontak',
            'alamat',
        )
            ->orderBy('supplier_id')
            ->get();

        // load excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID supplier');
        $sheet->setCellValue('C1', 'Nama supplier');
        $sheet->setCellValue('D1', 'Kontak');
        $sheet->setCellValue('E1', 'Alamat');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); ///bold header

        // looping data dari database
        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($supplier as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->supplier_id);
            $sheet->setCellValue('C'.$baris, $value->nama_supplier);
            $sheet->setCellValue('D'.$baris, $value->kontak);
            $sheet->setCellValue('E'.$baris, $value->alamat); // ambil alamat supplier
            $baris++;
            $no++;
        }

        //set lebar kolom
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); //set autosize
        }

        //set judul file
        $sheet->setTitle('Data Supplier'); // set title sheet

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier ' . date(format: 'Y-m-d H:i:s') . '.xlsx';

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

    } // end function export excel

    //fungsi export pdf
    public function export_pdf()
    {
        $supplier = SupplierModel::orderBy('supplier_id')
            ->orderBy('supplier_id')
            ->get();

        //use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = PDF::loadview('supplier.export_pdf', ['supplier' => $supplier]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();

        return $pdf->stream('Data supplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
