@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Tambah Supplier</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('supplier') }}" class="form-horizontal">
                @csrf

                {{-- Input untuk Nama Suplier --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Supplier</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier"
                            value="{{ old('nama_supplier') }}" required>
                        @error('nama_supplier')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Input untuk Alamat Suplier --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Alamat Supplier</label>
                    <div class="col-10">
                        <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Input untuk Nomor Telepon Suplier --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nomor Telepon Supplier</label>
                    <div class="col-10">
                        <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak') }}"
                            required>
                        @error('kontak')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Tombol Simpan dan Kembali --}}
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a class="btn btn-default ml-1" href="{{ url('supplier') }}">Kembali</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
