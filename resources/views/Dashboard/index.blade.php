@extends('Template.template')

@section('title','Trash Monitoring System | Dashboard')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
    @php
    $date = date('d');
    $day = date('l');
    $monthYear = date('F Y');
    @endphp
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
            </div>
            <section class="section">
                <div class="container-fluid">
                    <!-- ========== title-wrapper start ========== -->
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Dashboard Trash Monitoring System</h2>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="breadcrumb-wrapper mb-30">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                [ Dashboard ]
                                            </li>
                                            
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- ========== title-wrapper end ========== -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon purple">
                                    <i class="lni lni-stats-up"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Data Hari Ini</h6>
                                    <h3 class="text-bold mb-10">{{$iteration['hari']}}</h3>
                                    <p class="text-sm text-success">
                                        <span class="text-gray">{{$date}} {{$day}}</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon success">
                                    <i class="lni lni-layers"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Data Bulan Ini</h6>
                                    <h3 class="text-bold mb-10">{{$iteration['bulan']}}</h3>
                                    <p class="text-sm text-success">
                                        <span class="text-gray">{{$monthYear}}</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon primary">
                                    <i class="lni lni-credit-cards"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Volume Hari Ini</h6>
                                    <h3 class="text-bold mb-10">{{$berat['hari']}}</h3>
                                    <p class="text-sm text-danger">
                                        <span class="text-gray">Cubic Metre</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon orange">
                                    <i class="lni lni-cart-full "></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Volume Bulan Ini</h6>
                                    <h3 class="text-bold mb-10">{{$berat['bulan']}}</h3>
                                    <p class="text-sm text-danger">
                                        <span class="text-gray">Cubic Metre</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <div class="title d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="left">
                                        <h6 class="text-medium mb-30">Rekap Data</h6>
                                    </div>
                                    <div class="right">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select class="light-bg" id="dataOption" name="option">
                                                    <option value="Perhari" selected>Hari Ini</option>
                                                    <option value="Perbulan">Bulan Ini</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end select -->
                                    </div>
                                </div>
                                <!-- End Title -->
                                <div class="table-responsive">
                                    <table class="table" id="dashboard">
                                        <thead>
                                            <tr class="text-center">
                                                <th>
                                                    <h6 class="text-sm text-medium">Kabupaten / Kota</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Volume Hari Ini</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Jumlah Data Hari Ini</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!-- End Table -->
                                </div>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                </div>
                <!-- end container -->
            </section>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</section>
@endsection

@section('content')
<!-- ... konten lainnya ... -->

<!-- end select -->
</div>
</div>
<!-- End Title -->
<div class="table-responsive">
    <table class="table" id="dashboard">
        <thead>
            <tr class="text-center">
                <th>
                    <h6 class="text-sm text-medium">Kabupaten / Kota</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">Volume</h6>
                </th>
                <th class="min-width">
                    <h6 class="text-sm text-medium">Jumlah Data</h6>
                </th>
            </tr>
        </thead>
    </table>
    <!-- End Table -->
</div>
</div>
</div>
</div>
</div>
<!-- end container -->
</section>
<!-- end col -->
</div>
<!-- end row -->
</div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(function() {
        var table = $('#dashboard').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'kabkot',
                    name: 'kabkot'
                },
                {
                    data: 'volume',
                    name: 'volume',
                    searchable: false
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
            ],
            order: [
                [1, 'desc']
            ]
        });

        $('#dataOption').on('change', function() {
            table.ajax.url('/dashboard/data/' + $(this).val()).load(); // Mengubah URL AJAX dan memuat ulang tabel
        });
    });
</script>
@endpush