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

            <!-- Form Upload Foto -->
            <form id="avatarForm" enctype="multipart/form-data"> {{-- Form upload foto dengan enctype khusus untuk file --}}
                @csrf

                <!-- Body Modal -->
                <div class="modal-body">

                    <!-- Preview Foto Lama & Baru -->
                    <div class="text-center mb-4">
                        <div class="preview-container">
                            <div class="row">
                                <div class="col-6 text-center border-right">
                                    {{-- Foto saat ini --}}
                                    <p class="text-muted mb-2">Foto Saat Ini</p>
                                    @if (auth()->user()->photo)
                                        <img src="{{ asset('storage/profile/' . auth()->user()->photo) }}"
                                            class="img-circle elevation-2" alt="Current Avatar" width="120"
                                            height="120">
                                    @else
                                        <img src="{{ asset('adminlte/dist/img/avatar.png') }}"
                                            class="img-circle elevation-2" alt="Current Avatar" width="120"
                                            height="120">
                                    @endif
                                </div>
                                <div class="col-6 text-center">
                                    {{-- Preview foto baru yang akan diunggah --}}
                                    <p class="text-muted mb-2">Foto Baru</p>
                                    <img src="{{ asset('storage/profile/image.png') }}" class="img-circle elevation-2"
                                        alt="New Avatar" id="avatarPreview" width="120" height="120">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Input File -->
                    <div class="form-group mt-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="avatarInput" name="photo"
                                accept="image/*"> {{-- Input file untuk memilih foto baru --}}
                            <label class="custom-file-label" for="avatarInput">Pilih file</label>
                        </div>
                        <small class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimum 2MB.</small>
                    </div>

                    <!-- Alert Error -->
                    <div class="alert alert-danger d-none" id="avatarError"></div> {{-- Tempat menampilkan error upload --}}
                </div>

                <!-- Footer Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="saveAvatar">Simpan</button> {{-- Tombol simpan perubahan --}}
                </div>

            </form>
        </div>
    </div>
</div>

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
