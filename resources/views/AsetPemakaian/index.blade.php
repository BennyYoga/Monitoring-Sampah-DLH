@extends('Template.template')

@section('Pemakaian Aset','Trash Monitoring System | Pembelian Aset')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .text-center {
        text-align: center !important;
    }

    th,
    td {
        padding: 5px;
    }
</style>
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
                    <h2>Pemakaian Aset Barang</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Pemakaian Aset Barang</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Page
                            </li>
                        </ol>
                    </nav>
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
                            <table class="table" id="AsetPemakaian">
                                <div class="row">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <a href="{{route('aset.pemakaian.create')}}" class="btn btn-primary mb-3">
                                            Tambah Pemakaian Baru
                                        </a>
                                    </div>
                                </div>
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Tanggal Pemakaian</th>
                                        <th>Jumlah Barang</th>
                                        <th>Total Unit</th>
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
</section>



<div id="detail-pemakaian" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="edit-kondisi-alat" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Detail Pemakaian Barang</h5>
            </div>
            <div class="modal-body px-0">
                <div class="row">
                    <div class="col-sm-3">
                        Tanggal Pemakaian :
                    </div>
                    <div class="col-sm-3">
                        <span id="tanggal-pemakaian"></span>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">No</th>
                                    <th width="60%">Nama Barang</th>
                                    <th width="30%">Jumlah Unit</th>
                                </tr>
                            </thead>
                            <tbody id="list-barang">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="action d-flex flex-wrap justify-content-end mt-3">
                <button class="btn btn-primary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    function notificationDetailPemakaian(event, el) {
        event.preventDefault();
        {
            var data = $(el).data('id');
            console.log(data);
            $('#tanggal-pemakaian').text(data.Tanggal);
            $('#list-barang').empty();
            var totalUnit = 0
            data.detail_barang.forEach(function(item, index) {
                if (item.Merk != null) {
                    $('#list-barang').append('<tr><td>' + (index + 1) + '</td><td>' + item.NamaBarang + ' - ' + item.Merk + ' ' + item.Model + '</td><td>' + item.Unit + '</td></tr>');
                } else {
                    $('#list-barang').append('<tr><td>' + (index + 1) + '</td><td>' + item.NamaBarang + '</td><td>' + item.Unit + '</td></tr>');
                }
                totalUnit += item.Unit;
            });

            $('#list-barang').append(`
            <td colspan="2" class="text-center"><b>Total</b></td>
            <td>` + totalUnit + `</td>
            `);

            $('#detail-pemakaian').modal('show');
        }
    }

    $(document).ready(function() {
        var table = $('#AsetPemakaian').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'Tanggal',
                    name: 'Tanggal',
                },
                {
                    data: 'TotalBarang',
                    name: 'TotalBarang',
                },
                {
                    data: 'JumlahUnit',
                    name: 'JumlahUnit',
                },
                {
                    data: 'action',
                    name: 'action',
                    "className": "text-center"
                },
            ],
            order: [
                [
                    1, 'desc'
                ]
            ]
        });
    });
</script>
@endpush