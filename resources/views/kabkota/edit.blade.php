@extends('Template.template')

@section('title','Trash Monitoring System | Update Pegawai')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="tab-components">
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
                        <h2>Edit Data Pegawai</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="kabkota.index">Kabupaten Kota</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Update
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary w3-right">Add</button>
                    </div> --}}
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
    
    <form action="{{route('kabkota.update', ['id'=>$kabkota->id_kab_kota])}}" method="post">
        @csrf
        @method('POST')
        <input type="hidden" name="_method" value="PUT">
        <div class="form-elements-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <!-- input style start -->
                    <div class="card-style mb-30">
                        <div class="row">
                        <div class="input-style-1 col-lg-6">
                            <label>Nama Kabupaten / Kota</label>
                            <input type="text" placeholder="Kabupaten Kota" id="nama_kab_kota" name="nama_kab_kota" required autofocus value="{{$kabkota->nama_kab_kota}}"/>
                        </div>
                        <!-- end input -->
                        <!-- end input -->
                        <!-- end row -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="/pegawai" class="btn btn-light">
                                Batal
                            </a>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end wrapper -->
</section>
@endsection

@push('js')
@include('sweetalert::alert')
@endpush