@extends('Template.template')

@section('title', 'Trash Monitoring System | Dashboard')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Kabupaten / Kota</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Kabupaten Kota</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('kota.create') }}" class="btn btn-primary">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                            <div class="left">
                                <a href="{{ route('kabkota.document') }}" class="btn btn-danger mb-5">Download PDF</a>
                            </div>
                            {{-- <div class="right">
                                <div class="row">
                                    <div class="col-sm-6 contain">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select class="light-bg" id="filter-kota" name="option">
                                                    <option value="default">Semua Kota</option>
                                                    @foreach($kab_kota as $option)
                                                    <option value="{{$option->id_kab_kota}}">{{$option->nama_kab_kota}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div> --}}
                        </div>
                        <table class="table" id="kabkota">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>id Kabupaten Kota</th>
                                    <th>Kabupaten Kota</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Hapus Kabupaten/Kota</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Anda yakin ingin menghapus Kabupaten/Kota ini?
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
        $('#kabkota').on('click', '#hapusBtn', function (e) {
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
$(document).ready(function () {
    var table = $('#kabkota').DataTable({
        processing: true,
        serverSide: true,
        ajax: "",
        columns: [
            {"data": 'DT_RowIndex', orderable: false, searchable: false},
            { data : 'id_kab_kota', name: 'id_kab_kota', class:"text-center"},
            { data: 'nama_kab_kota', name: 'nama_kab_kota'},
            { data: 'action', name: 'action', orderable: false,  searchable: false }
        ]
    });
    $('.buttons-pdf').removeClass('btn-secondary').addClass('btn-danger');

});
</script>
@endpush
