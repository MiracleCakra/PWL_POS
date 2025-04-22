<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PWL Laravel Starter Code') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- untuk mengirimkan token laravel CSRF pada requests setiap ajax -->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    @stack('css') <!--Digunakan untuk memanggil custom css dari perintah push('css') pada masing masing view-->
</head>

<!--Navbar-->
@include('layouts.header')
<!--/.Navbar-->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PWL - Starter Code</span>
    </a>

    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts.breadcrumb')

    <!-- Main content -->
    <section class="content">
        @yield('content')

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- Change Avatar Modal -->
<div class="modal fade" id="changeAvatarModal" tabindex="-1" role="dialog" aria-labelledby="changeAvatarModalLabel"
    aria-hidden="true">
    {{-- Modal Bootstrap untuk mengganti foto profil --}}
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!-- Header Modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="changeAvatarModalLabel">Ganti Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body Modal -->
            <style>
                .avatar-upload-container {
                  font-family: 'Poppins', sans-serif;
                  max-width: 550px;
                  margin: 0 auto;
                  padding: 20px;
                }

                .upload-header {
                  text-align: center;
                  margin-bottom: 30px;
                }

                .upload-header h5 {
                  font-weight: 600;
                  color: #333;
                  margin-bottom: 10px;
                }

                .upload-header p {
                  color: #6c757d;
                  font-size: 14px;
                }

                .preview-container {
                  display: flex;
                  justify-content: space-around;
                  align-items: center;
                  margin-bottom: 30px;
                  padding: 15px 0;
                  background-color: #f8f9fa;
                  border-radius: 10px;
                }

                .preview-box {
                  display: flex;
                  flex-direction: column;
                  align-items: center;
                  padding: 10px;
                  width: 45%;
                }

                .preview-box p {
                  margin-bottom: 10px;
                  font-weight: 500;
                  color: #495057;
                }

                .avatar-circle {
                  width: 120px;
                  height: 120px;
                  border-radius: 50%;
                  object-fit: cover;
                  border: 3px solid #fff;
                  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
                }

                .preview-divider {
                  width: 1px;
                  height: 120px;
                  background-color: #dee2e6;
                }

                .drop-zone {
                  display: flex;
                  flex-direction: column;
                  align-items: center;
                  justify-content: center;
                  border: 2px dashed #adb5bd;
                  border-radius: 8px;
                  padding: 20px;
                  text-align: center;
                  background-color: #f8f9fa;
                  cursor: pointer;
                  margin-bottom: 15px;
                }

                .drop-zone:hover {
                  border-color: #007bff;
                  background-color: #f1f8ff;
                }

                .drop-zone-active {
                  border-color: #28a745;
                  background-color: #f0fff4;
                }

                .drop-zone i {
                  font-size: 32px;
                  color: #6c757d;
                  margin-bottom: 10px;
                }

                .drop-zone-text {
                  color: #495057;
                  font-weight: 500;
                  margin-bottom: 8px;
                }

                .drop-zone-hint {
                  color: #6c757d;
                  font-size: 13px;
                }

                .file-input {
                  display: none;
                }

                .file-info {
                  display: flex;
                  align-items: center;
                  font-size: 14px;
                  color: #6c757d;
                  padding: 8px;
                  background: #fff;
                  border-radius: 6px;
                  margin-bottom: 15px;
                }

                .file-info i {
                  margin-right: 8px;
                }

                .btn-container {
                  display: flex;
                  justify-content: flex-end;
                  gap: 10px;
                  margin-top: 15px;
                }

                .btn {
                  padding: 8px 16px;
                  border-radius: 6px;
                  font-weight: 500;
                }

                .btn-cancel {
                  background-color: #fff;
                  color: #6c757d;
                  border: 1px solid #ced4da;
                }

                .btn-cancel:hover {
                  background-color: #f8f9fa;
                }

                .btn-save {
                  background-color: #007bff;
                  color: white;
                  border: none;
                }

                .btn-save:hover {
                  background-color: #0069d9;
                }

                .alert-error {
                  color: #721c24;
                  background-color: #f8d7da;
                  border: 1px solid #f5c6cb;
                  border-radius: 6px;
                  padding: 10px;
                  margin-top: 10px;
                  display: none;
                }

                .progress-bar-container {
                  height: 6px;
                  width: 100%;
                  background-color: #e9ecef;
                  border-radius: 3px;
                  overflow: hidden;
                  margin-bottom: 15px;
                  display: none;
                }

                .progress-bar {
                  height: 100%;
                  background-color: #007bff;
                  border-radius: 3px;
                  width: 0%;
                }

                @keyframes pulse {
                  0% { transform: scale(1); }
                  50% { transform: scale(1.05); }
                  100% { transform: scale(1); }
                }

                .avatar-highlight {
                  animation: pulse 1s ease-in-out;
                }
                </style>

                <form id="avatarForm" enctype="multipart/form-data" class="avatar-upload-container">
                    @csrf

                    <div class="upload-header">
                        <h5>Perbarui Foto Profil</h5>
                        <p>Pilih foto untuk profil baru Anda</p>
                    </div>

                    <div class="preview-container">
                        <div class="preview-box">
                            <p>Foto Saat Ini</p>
                            @if (auth()->user()->foto_profil)
                                <img src="{{ asset('storage/profile/' . auth()->user()->foto_profil) }}"
                                    class="avatar-circle" alt="Foto Saat Ini" id="currentAvatar">
                            @else
                                <img src="{{ asset('adminlte/dist/img/avatar.png') }}"
                                    class="avatar-circle" alt="Foto Default" id="currentAvatar">
                            @endif
                        </div>

                        <div class="preview-divider"></div>

                        <div class="preview-box">
                            <p>Foto Baru</p>
                            <img src="{{ asset('adminlte/dist/img/avatar.png') }}" class="avatar-circle"
                                alt="Foto Baru" id="avatarPreview">
                        </div>
                    </div>

                    <div class="drop-zone" id="dropZone">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p class="drop-zone-text">Tarik & lepas foto di sini</p>
                        <p class="drop-zone-hint">- atau -</p>
                        <button type="button" class="btn btn-outline-primary" id="browseBtn">Pilih File</button>
                        <input type="file" class="file-input" id="avatarInput" name="photo" accept="image/*">
                    </div>

                    <div class="file-info" id="fileInfo" style="display: none;">
                        <i class="fas fa-file-image"></i>
                        <span id="fileName">Tidak ada file dipilih</span>
                    </div>

                    <div class="progress-bar-container" id="progressContainer">
                        <div class="progress-bar" id="progressBar"></div>
                    </div>

                    <div class="alert-error" id="avatarError"></div>

                    <div class="btn-container">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-save" id="saveAvatar">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Inisialisasi elemen-elemen DOM
                    const dropZone = document.getElementById('dropZone');
                    const fileInput = document.getElementById('avatarInput');
                    const browseBtn = document.getElementById('browseBtn');
                    const avatarPreview = document.getElementById('avatarPreview');
                    const fileName = document.getElementById('fileName');
                    const fileInfo = document.getElementById('fileInfo');
                    const errorAlert = document.getElementById('avatarError');
                    const progressContainer = document.getElementById('progressContainer');
                    const progressBar = document.getElementById('progressBar');
                    const saveBtn = document.getElementById('saveAvatar');

                    // Penanganan klik tombol browse
                    browseBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        fileInput.click();
                    });

                    // Penanganan pemilihan file
                    fileInput.addEventListener('change', handleFileSelect);

                    // Penanganan drag and drop
                    dropZone.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        dropZone.classList.add('drop-zone-active');
                    });

                    dropZone.addEventListener('dragleave', function() {
                        dropZone.classList.remove('drop-zone-active');
                    });

                    dropZone.addEventListener('drop', function(e) {
                        e.preventDefault();
                        dropZone.classList.remove('drop-zone-active');

                        if (e.dataTransfer.files.length) {
                            fileInput.files = e.dataTransfer.files;
                            handleFileSelect();
                        }
                    });

                    // Penanganan submit form
                    document.getElementById('avatarForm').addEventListener('submit', function(e) {
                        e.preventDefault();

                        if (!fileInput.files.length) {
                            showError('Silakan pilih foto terlebih dahulu.');
                            return;
                        }

                        // Simulasi upload dengan progress bar
                        simulateUpload();
                    });

                    // untuk menangani pemilihan file
                    function handleFileSelect() {
                        const file = fileInput.files[0];

                        if (!file) return;

                        // Periksa tipe file
                        const fileType = file.type;
                        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                        if (!validTypes.includes(fileType)) {
                            showError('Format file tidak valid. Gunakan JPG, JPEG, atau PNG.');
                            resetFileInput();
                            return;
                        }

                        // Periksa ukuran file (maks 2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            showError('Ukuran file terlalu besar. Maksimal 2MB.');
                            resetFileInput();
                            return;
                        }

                        // Tampilkan pratinjau gambar
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.classList.add('avatar-highlight');
                            setTimeout(() => {
                                avatarPreview.classList.remove('avatar-highlight');
                            }, 1000);
                        }
                        reader.readAsDataURL(file);

                        // Tampilkan info file
                        fileName.textContent = file.name;
                        fileInfo.style.display = 'flex';

                        // Sembunyikan pesan error jika ada
                        errorAlert.style.display = 'none';
                    }

                    // untuk mereset input file
                    function resetFileInput() {
                        fileInput.value = '';
                        fileInfo.style.display = 'none';
                        avatarPreview.src = '{{ asset("adminlte/dist/img/avatar.png") }}';
                    }

                    // untuk menampilkan pesan error
                    function showError(message) {
                        errorAlert.textContent = message;
                        errorAlert.style.display = 'block';
                    }

                    // untuk mensimulasikan upload
                    function simulateUpload() {
                        // Tampilkan progress bar
                        progressContainer.style.display = 'block';
                        saveBtn.disabled = true;

                        let progress = 0;
                        const interval = setInterval(() => {
                            progress += 10;
                            progressBar.style.width = progress + '%';

                            if (progress >= 100) {
                                clearInterval(interval);
                                setTimeout(() => {
                                    progressContainer.style.display = 'none';
                                    saveBtn.disabled = false;
                                }, 500);
                            }
                        }, 100);
                    }
                });
                </script>
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- DataTables & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
    // Untuk mengirimkan token Laravel CSRF pada setiap request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@push('js')
    <script>
        $(function() {

            // Blok 1: Preview gambar dan tampilkan nama file saat dipilih
            $('#avatarInput').on('change', function() {
                let fileName = $(this).val().split('\\').pop(); // Ambil nama file
                $(this).next('.custom-file-label').addClass("selected").html(
                    fileName); // Tampilkan nama di label

                // Preview gambar
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#avatarPreview').attr('src', e.target.result); // Tampilkan preview
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Blok 2: Reset form dan preview saat modal ditutup
            $('#changeAvatarModal').on('hidden.bs.modal', function() {
                $('#avatarForm').trigger('reset'); // Reset form input
                $('.custom-file-label').text('Pilih file'); // Reset label file
                $('#avatarError').addClass('d-none').html(''); // Sembunyikan pesan error

                // Reset preview ke default
                $('#avatarPreview').attr('src', '{{ asset('adminlte/dist/img/avatar.png') }}');
            });

            // Blok 3: Handle submit form via AJAX
            $('#avatarForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this); // Ambil data file

                $('#avatarError').addClass('d-none').html(''); // Reset error

                $.ajax({
                    url: "{{ url('/profile/update-avatar') }}", // Endpoint update avatar
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,

                    beforeSend: function() {
                        // Ubah tombol simpan jadi loading
                        $('#saveAvatar').html(
                            '<i class="fas fa-spinner fa-spin"></i> Menyimpan...').attr(
                            'disabled', true);
                    },

                    success: function(response) {
                        const newPhotoUrl = response.photo_url;

                        // Update semua avatar yang tampil di halaman
                        $('#avatarDropdown img').attr('src', newPhotoUrl);
                        $('.dropdown-item img[alt="User Image"]').attr('src', newPhotoUrl);

                        // Tampilkan notifikasi sukses
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            alert(response.message);
                        }

                        // Tutup modal setelah sukses
                        $('#changeAvatarModal').modal('hide');
                    },

                    error: function(xhr) {
                        $('#saveAvatar').html('Simpan').attr('disabled', false);

                        // Tampilkan error validasi
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.photo) {
                                $('#avatarError').removeClass('d-none').html(errors.photo[0]);
                            }
                        } else {
                            $('#avatarError').removeClass('d-none').html(
                                'Terjadi kesalahan. Silakan coba lagi.');
                        }
                    },

                    complete: function() {
                        // Aktifkan kembali tombol setelah proses selesai
                        $('#saveAvatar').html('Simpan').attr('disabled', false);
                    }
                });
            });
        });
    </script>
@endpush

@stack('js') <!-- Digunakan untuk menangani custom JS dari perintah push('js') pada masing-masing view -->

    </body>

</html>
