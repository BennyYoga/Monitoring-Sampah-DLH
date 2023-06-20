@extends('template.template')

@section('title','Portal Admin Desa | Dashboard')

{{-- kalau ada css tambahan selain dari template.blade --}}
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
                    {{-- @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                </div>
                @endif --}}
                <div class="titlemb-30">
                    <h2>Data Kabupaten / Kota</h2>
                </div>
                <form action="" method="post">
                    <div class="input-style-1">
                        <label>Nama Kota</label>
                        <input type="text" placeholder="Masukkan Nama Kota/Kabupaten" name="nama_kota_kab">
                    </div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/kota" class="btn btn-default">
                        Batal
                    </a>
                </div>
                </form>

    
                        
                @endsection