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
                        <h2>Tiket</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Pegawai</a>
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
                <div class="card">
                    <div class="card-body">
                        <div class="title d-flex flex-wrap align-items-center justify-content-between">
                            <div class="left">
                                <button id="print" class="btn btn-danger mb-5">
                                    Download PDF
                                </button>
                            </div>
                            <div class="right">
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
                                    <div class="col-sm-6 contain">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select class="light-bg" id="filter-hari" name="option">
                                                    <option value="SemuaHari">Semua Hari</option>
                                                    <option value="Hari">Perhari</option>
                                                    <option value="Bulan">Perbulan</option>
                                                    <option value="Tahun">Pertaun</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm calendar d-none" id="calendarContainer">
                                                <input id="filter-calendar" class="input-calendar" type="date" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div>
                        </div>
                        <table class="table" id="tiket">
                            <thead>
                                <tr class="text-center">
                                    <th>Tanggal</th>
                                    <th>Jam<br>Masuk</th>
                                    <th>Jam<br>keluar</th>
                                    <th>Nomor<br>Kendaraan</th>
                                    <th>Jenis<br>Kendaraan</th>
                                    <th>Pengemudi</th>
                                    <th>Lokasi</th>
                                    <th>Volume</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                        </table>
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
<script type="text/javascript">
    var select = document.getElementById("filter-hari");
    var calendarContainer = document.getElementById("calendarContainer");
    var calendarInput = calendarContainer.querySelector("input");
    var contain = document.getElementsByClassName("contain");

    select.addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex].value;

        if (selectedOption === "Bulan") {
            calendarInput.type = "month";
            calendarContainer.classList.remove("d-none");
            for (var i = 0; i < contain.length; i++) {
                contain[i].classList.remove("col-sm-6");
                contain[i].classList.add("col-sm-4");
            }
        } else if (selectedOption === "Hari") {
            calendarInput.type = "date";
            calendarContainer.classList.remove("d-none");
            for (var i = 0; i < contain.length; i++) {
                contain[i].classList.remove("col-sm-6");
                contain[i].classList.add("col-sm-4");
            }
        } else if (selectedOption === "Tahun") {
            calendarInput.type = "number";
            calendarContainer.classList.remove("d-none");
            for (var i = 0; i < contain.length; i++) {
                contain[i].classList.remove("col-sm-6");
                contain[i].classList.add("col-sm-4");
            }
        } else {
            calendarContainer.classList.add("d-none");
            for (var i = 0; i < contain.length; i++) {
                contain[i].classList.remove("col-sm-4");
                contain[i].classList.add("col-sm-6");
            }
        }
    });


    $(function() {
        // Initialize DataTable
        var table = $('#tiket').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'bulan',
                    name: 'bulan'
                },
                {
                    data: 'jam_masuk',
                    name: 'jam_masuk'
                },
                {
                    data: 'jam_keluar',
                    name: 'jam_keluar',
                    orderable: true
                },
                {
                    data: 'no_kendaraan',
                    name: 'no_kendaraan'
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


            ],
        });

        // Filter data based on selected Kabupaten/Kota
        $('#filter-kota, #filter-calendar, #filter-hari').on('change', function() {
            var Pilihan = $('#filter-hari').val();
            var inputKota = $('#filter-kota').val();
            var inputHari = $('#filter-calendar').val();

            if (Pilihan == 'SemuaHari') {
                inputHari = 'all'
                table.ajax.url('/tiket/rekap/data/' + inputKota + '/' + inputHari).load(); // Mengubah URL AJAX dan memuat ulang tabel
            } else if (inputHari) {
                table.ajax.url('/tiket/rekap/data/' + inputKota + '/' + inputHari).load(); // Mengubah URL AJAX dan memuat ulang tabel
            }
        });

        $("#print").click(function() {
            let dataTable = table.data().length
            var Pilihan = $('#filter-hari').val();
            var inputKota = $('#filter-kota').val();
            var inputHari = $('#filter-calendar').val();
            if (Pilihan == 'SemuaHari') {
                inputHari = 'all'
                window.location.href = '/tiket/rekap/print/' + inputKota + '/' + inputHari;
            } else if (inputHari) {
                window.location.href = '/tiket/rekap/print/' + inputKota + '/' + inputHari;
            }
        });
    });
</script>
@endpush