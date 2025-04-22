<?php

use App\Http\Controllers\LevelController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter id, maka harus berupa angka

// Routes for login (auth.login)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
// Menampilkan halaman register
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');

// Proses registrasi
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index']);
});

//Route untuk foto profile
Route::post('/profile/update-avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar']);

// Route User
Route::middleware(['auth', 'authorize:ADM,MNG'])->group(function () {
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']); // Menambahkan rute POST
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}/show', [UserController::class, 'show']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
Route::get('/export_excel', [UserController::class, 'export_excel']); // ajax export excel
Route::get('/export_pdf', [UserController::class, 'export_pdf']); // export pdf
    });
});

//Route Level
Route::middleware(['auth', 'authorize:ADM,MNG'])->group(function () {
    Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'index']);
        Route::get('/list', [LevelController::class, 'list']);
        Route::post('/', [LevelController::class, 'store']);
        Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/{id}/show', [LevelController::class, 'show']);
        Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
    Route::get('/import', [LevelController::class, 'import']); // ajax form upload excel
    Route::post('/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
    Route::get('/export_excel', [LevelController::class, 'export_excel']); // ajax export excel
    Route::get('/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
        });
    });

// // Route Level
// Route::group(['prefix' => 'level'], function () {
//     Route::get('/', [LevelController::class, 'index']);
//     Route::get('/list', [LevelController::class, 'list']);
//     Route::get('/create', [LevelController::class, 'create']);
//     Route::post('/', [LevelController::class, 'store']);
//     Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
//     Route::post('/ajax', [LevelController::class, 'store_ajax']);
//     Route::get('/{id}/show', [LevelController::class, 'show']);
//     Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
// });

// Route Kategori
    //     Route::group(['prefix' => 'kategori'], function () {
    //     Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
    //     Route::post('/list', [KategoriController::class, 'list'])->name('kategori.list');
    //     Route::get('/create', [KategoriController::class, 'create'])->name('kategori.create');
    //     Route::post('/', [KategoriController::class, 'store'])->name('kategori.store');
    //     Route::get('/create_ajax', [KategoriController::class, 'create_ajax'])->name('kategori.create_ajax');
    //     Route::post('ajax', [KategoriController::class, 'store_ajax'])->name('kategori.ajax');
    //     Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show');
    //     Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    //     Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    //     Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax'])->name('kategori.edit_ajax');
    //     Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax'])->name('kategori.update_ajax');
    //     Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    //     Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    //     Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    // });

    // Route Kategori
    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::get('/list', [KategoriController::class, 'list']);
        Route::get('/create', [KategoriController::class, 'create']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax'])->withoutMiddleware('auth');
        Route::get('/{id}/show', [KategoriController::class, 'show']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
    Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
    Route::get('/export_excel', [KategoriController::class, 'export_excel']); // ajax export excel
    Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); // export pdf
    });

// Route Supplier
//     Route::group(['prefix' => 'supplier'], function () {
//     Route::get('/', [SupplierController::class, 'index']);
//     Route::post('/list', [SupplierController::class, 'list']);
//     Route::get('/create', [SupplierController::class, 'create']);
//     Route::post('/', [SupplierController::class, 'store']);
//     Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
//     Route::post('/ajax', [SupplierController::class, 'store_ajax']);
//     Route::get('/{id}', [SupplierController::class, 'show']);
//     Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
//     Route::get('/{id}/edit', [SupplierController::class, 'edit']);
//     Route::put('/{id}', [SupplierController::class, 'update']);
//     Route::get('/{id}/edit_ajax',  [SupplierController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
//     Route::delete('/{id}', [SupplierController::class, 'destroy']);
//     Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
// });

    // Route Supplier
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/list', [SupplierController::class, 'list']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);
        Route::get('/{id}/show', [SupplierController::class, 'show']);
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
    Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
    Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
    Route::get('/export_excel', [SupplierController::class, 'export_excel']); // ajax export excel
    Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); // export pdf
    });


// // Route Barang
// Route::group(['prefix' => 'barang'], function () {
//     Route::get('/', [BarangController::class, 'index']);
//     Route::post('/list', [BarangController::class, 'list']);
//     Route::get('/create', [BarangController::class, 'create']);
//     Route::post('/', [BarangController::class, 'store']);
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
//     Route::post('/ajax', [BarangController::class, 'store_ajax']);
//     Route::get('/{id}', [BarangController::class, 'show']);
//     Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);
//     Route::put('/{id}', [BarangController::class, 'update']);
//     Route::get('/{id}/edit_ajax',  [BarangController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
//     Route::delete('/{id}', [BarangController::class, 'destroy']);
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
//});

// artinya semua route di dalam group ini harus punay role ADM (Administrator) dan MNG (Manager)
// Route::middleware(['authorize:ADM,MNG'])->group(function(){
//     Route::get('/barang',[BarangController::class,'index']);
//     Route::post('/barang/list',[BarangController::class,'list']);
//     Route::get('/barang/create_ajax',[BarangController::class,'create_ajax']); // ajax form create
//     Route::post('/barang_ajax',[BarangController::class,'store_ajax']); // ajax store
//     Route::get('/barang/{id}/edit_ajax',[BarangController::class,'edit_ajax']); // ajax form edit
//     Route::put('/barang/{id}/update_ajax',[BarangController::class,'update_ajax']); // ajax update
//     Route::get('/barang/{id}/delete_ajax',[BarangController::class,'confirm_ajax']); // ajax form confirm
//     Route::delete('/barang/{id}/delete_ajax',[BarangController::class,'delete_ajax']); // ajax delete
// });

// Route Barang
Route::get('/barang',[BarangController::class,'index']);
Route::post('/barang/list',[BarangController::class,'list']);
Route::get('/barang/create_ajax',[BarangController::class,'create_ajax']); // ajax form create
Route::get('/barang/{id}/show', [BarangController::class, 'show']);
Route::post('/barang_ajax',[BarangController::class,'store_ajax']); // ajax store
Route::get('/barang/{id}/edit_ajax',[BarangController::class,'edit_ajax']); // ajax form edit
Route::put('/barang/{id}/update_ajax',[BarangController::class,'update_ajax']); // ajax update
Route::get('/barang/{id}/delete_ajax',[BarangController::class,'confirm_ajax']); // ajax form confirm
Route::delete('/barang/{id}/delete_ajax',[BarangController::class,'delete_ajax']); // ajax delete
Route::get('/barang/import',[BarangController::class,'import']); // ajax form upload excel
Route::post('/barang/import_ajax',[BarangController::class,'import_ajax']); // ajax import excel
Route::get('/barang/export_excel', [BarangController :: class, 'export_excel']); // export excel
Route::get('/barang/export_pdf', [BarangController :: class, 'export_pdf']); // export pdf

