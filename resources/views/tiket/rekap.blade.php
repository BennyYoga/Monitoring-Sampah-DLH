@extends('Template.template')

@section('title', 'Trash Monitoring System | Dashboard')

@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    #dates {
        background-color: #f7f7f7;
        border: 1px solid #e5e5e5;
        text-align: center;
        padding: 6.5px;
        border-radius: 10px;
        color: #6c7387;
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
                    <div class="title mb-30">
                        <h2>Tiket</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Rekap Tiket</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Page
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card pb-4">
                    <div class="container">
                        <div class="contcard-body">
                            <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                <div class="left">
                                    <button id="print" class="btn btn-danger">
                                        Download PDF
                                    </button>
                                    <button id="printExcel" class="btn btn-success">
                                        Download Excel
                                    </button>
                                </div>
                                <div class="right mt-4">
                                    <div class="row">
                                        <div class="col-sm-6 contain">
                                            <div class="select-style-1">
                                                <div class="select-position select-sm">
                                                    <select class="light-bg" id="filter-kota" name="option">
                                                        <option value="undefined">Semua Kota</option>
                                                        @foreach($kab_kota as $option)
                                                        <option value="{{$option->id_kab_kota}}">{{$option->nama_kab_kota}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 contain">
                                            <input type="text" name="dates" id="dates" value="" placeholder="Choose Date" />
                                        </div>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div>
                        </div>
                        <table class="table pb-3" id="tiket">
                            <thead>
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Jam<br>Masuk</th>
                                    <th>Jam<br>keluar</th>
                                    <th>Nomor Kendaraan</th>
                                    <th>Jenis<br>Kendaraan</th>
                                    <th>Pengemudi</th>
                                    <th>Lokasi</th>
                                    <th>Volume</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
    </div>
</section>

<style>
    .calendar {
        background-color: white;
        border: 1px solid rgba(25, 25, 25, 0.1);
        padding: 2px;
        padding-bottom: 7px;
        border-radius: 10px;
        background-color: rgba(25, 25, 25, 0.04);
        margin: auto;
        text-align: center;
        padding-top: 7px;
    }

    .input-calendar {
        color: rgba(25, 25, 25, 0.65);
        border: 0px solid transparent;
    }
</style>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    var table
    $(function() {
        // Initialize DataTable
        table = $('#tiket').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    'name': 'bulan',
                    'data': {
                        '_': 'bulan.display',
                        'sort': 'bulan.timestamp'
                    },
                    width: '13%'
                },
                {
                    data: 'jam_masuk',
                    name: 'jam_masuk',
                },
                {
                    data: 'jam_keluar',
                    name: 'jam_keluar',
                },
                {
                    data: 'no_kendaraan',
                    name: 'no_kendaraan',
                },
                {
                    data: 'jenis_kendaraan',
                    name: 'jenis_kendaraan'
                },
                {
                    name: 'pengemudi',
                    data: 'pengemudi'
                },
                {
                    data: 'lokasi_sampah',
                    name: 'lokasi_sampah'
                },
                {
                    name: 'volume',
                    data: 'volume'
                },
                {
                    name: 'action',
                    data: 'action'
                },
            ],
            order: [
                [0, "DESC"]
            ],
        });

        $(function() {

            let dateRange;
            let inputKota;

            $("#filter-kota").on('change', function() {
                inputKota = $('#filter-kota').val()
                console.log(inputKota + ' ' + dateRange);
                table.ajax.url('/tiket/rekap/data/' + inputKota + '/' + dateRange).load()
            })

            $('input[name="dates"]').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                inputKota = $('#filter-kota').val();
                dateRange = $(this).val()
                dateRange = dateRange.replace(/\//g, '-')
                console.log(inputKota + ' ' + dateRange);

                table.ajax.url('/tiket/rekap/data/' + inputKota + '/' + dateRange).load()
            });

            $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('Choose Date');
                inputKota = $('#filter-kota').val();
                dateRange = undefined
                console.log(inputKota + ' ' + dateRange);

                table.ajax.url('/tiket/rekap/data/' + inputKota + '/' + dateRange).load()
            });

            $("#print").click(function() {
                window.location.href = '/tiket/rekap/print/' + inputKota + '/' + dateRange;
            });
            $("#printExcel").click(function() {
                window.location.href = '/tiket/print-excel/' + inputKota + '/' + dateRange;
            });
        });
    });
</script>
@endpush