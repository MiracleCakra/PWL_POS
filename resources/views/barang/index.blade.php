@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="barang_kode" name="barang_kode">
                                <option value="">- Semua -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_kode }}">{{ $item->barang_nama }} -
                                        Rp{{ number_format($item->harga_beli) }} / Rp{{ number_format($item->harga_jual) }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kode Barang</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataBarang = $('#table_barang').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function(d) {
                        d.barang_kode = $('#barang_kode').val();
                    }
                },
                columns: [{
                        data: "barang_id",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "barang_kode",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "barang_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#barang_kode').on('change', function() {
                dataBarang.ajax.reload();
            });

        });
    </script>
@endpush
