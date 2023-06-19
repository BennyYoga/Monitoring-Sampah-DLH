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
                <div class = "table-wrapper table-responsive">
                    <table class ="table">
                        <thead>
                            <tr>
                                <th><h6>No</h6></th>
                                <th><h6>Nama Kabupaten/Kota</h6></th>
                                <th><h6>action</h6></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kabkota as $key=> $kabkota)
                            <tr>
                                <td class="min-width">{{$key+1}}</td>
                                <td class="min-width">{{$kabkota->nama_kab_kota}}</td>
                                <td>
                                    <a href="" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                                <!-- <td class="min-width">{{}}</td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Kabupaten Kota</a>
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
    </div>
</section>
@endsection