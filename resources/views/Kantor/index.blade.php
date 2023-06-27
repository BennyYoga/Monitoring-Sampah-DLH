@extends('Template.template')

@section('title','Trash Monitoring System | Kantor')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    {{-- @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif --}}
                    <div class="title mb-30">
                        <h2>Data Kantor</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#0">Kantor</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('kantor.create') }}" class="btn btn-primary">Add</a>
                        <a href="{{ route('kantor.document') }}" class="btn btn-success ml-2">Print</a>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <!-- star Row -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="table-wrapper table-responsive">
                                <table class="table" id="kantor">
                                    <thead>
                                        <tr class="text-center">
                                            {{-- <th>ID Kantor</th> --}}
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Hapus Kantor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        Anda yakin ingin menghapus kantor ini?
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" id="hapusBtnModal">Ya, hapus</button>
                        </div>
                    </div>
                    </div>
                </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>

<form action="" id="delete-form" method="post">
    @method('get')
    @csrf
</form>
<script>
    $(document).ready(function () {
        // Menggunakan event click untuk button dengan id hapusBtn
        $('#kantor').on('click', '#hapusBtn', function (e) {
            e.preventDefault();

            // Simpan URL hapus pada atribut data-hapus pada tombol hapus
            var deleteUrl = $(this).attr('href');
            $('#hapusBtn').attr('data-hapus', deleteUrl);

            // Menampilkan modal
            $('#staticBackdrop').modal('show');
        });

        // Menggunakan event click untuk button hapus pada modal
        $('#hapusBtnModal').on('click', function () {
            // Mengambil URL hapus dari atribut data-hapus pada tombol hapus
            var deleteUrl = $('#hapusBtn').attr('data-hapus');

            // Mengubah action pada form hapus sesuai dengan URL hapus
            $('#delete-form').attr('action', deleteUrl);

            // Submit form hapus
            $("#delete-form").submit();
        });
    });
</script>
<script type="text/javascript">
$('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
    $(function () {
    var table = $('#kantor').DataTable({
        dom: 'Bfrtip',
        buttons: [
           {
               extend: 'pdf',
               exportOptions: {
                   columns: [0, 1, 2] // Kolom yang ingin disertakan dalam ekspor
               },
               customize: function (doc) {
                doc.defaultStyle = {
                color: '#000'
                };
                doc.pageSize = 'A4'; // Mengatur ukuran halaman
                doc.pageOrientation = 'potrait'; // Mengatur orientasi halaman
                doc.content[1].table.widths = ['5%', '40%', '55%']; // Mengatur lebar kolom secara manual
                },
           }
       ],
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [
            // {data: 'id_kantor', name: 'id_kantor'},
            {   
            data: null,
            render: function (data, type, row, meta) {
                // Menghitung nomor urut berdasarkan halaman dan jumlah baris yang ditampilkan
                var startIndex = meta.settings._iDisplayStart;
                var index = meta.row + startIndex + 1;

                return index;
            },
            orderable: false,
            searchable: false
            },
            {data: 'nama_kantor', name: 'nama_kantor'},
            {data: 'alamat_kantor', name: 'alamat_kantor'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-danger');
    
  });
</script>
@endpush