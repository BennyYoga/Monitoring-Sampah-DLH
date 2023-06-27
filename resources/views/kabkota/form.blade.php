@extends('Template.template')

@section('title','Trash Monitoring System | Dashboard')

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
                    <div class="titlemb-30">
                        <h2>Tambah Data Kabupaten / Kota</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper mb-30">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#">Kabupaten kota</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="Add">
                                    Add
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!-- end col -->
                <form action="{{route('kota.post')}}" method="POST">
                    @csrf
                    <div class="form-elements-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-style mb-30">
                                    <div class="input-style-1">
                                        <label>Nama Kabupaten / Kota</label>
                                        <input type="text" placeholder="Kabupaten Kota" id="nama_kab_kota"
                                            name="nama_kab_kota" required autofocus />
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <a href="/kota" class="btn btn-light">
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
            </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
@endpush