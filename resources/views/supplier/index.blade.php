@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/supplier/import') }}')" class="btn btn-info btn-sm mt-1">Import Supplier</button>
                    <a href="{{ url('/supplier/export_excel') }}" class="btn btn-primary"><i class="fa fa-file excel"></i> Export Supplier Excel</a>
                    <a href="{{ url('/supplier/export_pdf') }}" class="btn btn-danger"><i class="fa fa-file pdf"></i> Export Supplier PDF</a>
                <button onclick="modalAction('{{ url('supplier/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tableSupplier;
        $(document).ready(function() {
            tableSupplier = $('#table_supplier').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('supplier/list') }}",
                    "dataType": "json",
                    "type": "GET",
                    "data": function(d) {
                        d.filter_supplier = $('.filter_supplier').val();
                    }
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_supplier",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kontak",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "alamat",
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
            $('#table_supplier_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableSupplier.search(this.value).draw();
                }
            });
            $('.filter_supplier').change(function() {
                tableSupplier.draw();
            });
        });
    </script>
@endpush
