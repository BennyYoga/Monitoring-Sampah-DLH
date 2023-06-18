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
                    <h2>Tiket</h2>
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
                            <li class="breadcrumb-item">
                                <a href="/tiket/create">Add</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="/tiket">Page</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <div class = "table-wrapper table-responsive">
                    <table class ="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Nomor Kendaraan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Pengemudi</th>
                                <th>Lokasi</th>
                                <th>Volume</th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tiket as $key=> $tiket)
                            <tr>
                                <td class="min-width">{{$key+1}}</td>
                                    <td class="min-width">{{$tiket->jam_masuk}}</td>
                                    <td class="min-width">{{$tiket->jam_keluar}}</td>
                                    <td class="min-width">{{$tiket->no_kendaraan}}</td>
                                    <td class="min-width">{{$tiket->jenis_kendaraan}}</td>
                                    <td class="min-width">{{$tiket->pengemudi}}</td>
                                    <td class="min-width">{{$tiket->lokasi_sampah}}</td>
                                    <td class="min-width">{{$tiket->volume}}</td>
                                    <td>
                                        <a href="{{route('tiket.edit', $tiket->id)}}" class="btn btn-primary btn-xs">  
                                            Edit
                                        </a>
                                    </td>
                                <!-- <td class="min-width">{{}}</td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        <!-- end row -->
    </div>

</section>
@endsection