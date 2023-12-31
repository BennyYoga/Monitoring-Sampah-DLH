@extends('Template.template')

@section('title','Trash Monitoring System | Edit')

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
                    <h2>Input Data Tiket</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/tiket">list tiket</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Page
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
            <form action="{{route('tiket.update', ['id'=>$tiket->id])}}" method="POST"> 
                @csrf
                @method('POST')
                <input type="hidden" name="_method" value="PUT">
                <div class="row">
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>Pengemudi</label>
                      <input type="text" placeholder="Pengemudi" id="pengemudi" name="pengemudi" required autofocus value="{{$tiket->pengemudi}}" />
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>Jenis Kendaraan</label>
                      <input type="text" placeholder="Jenis Kendaraan" id="jenis_kendaraan" name="jenis_kendaraan" required autofocus value="{{$tiket->jenis_kendaraan}}" />
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>Jenis Kendaraan</label>
                      <input type="text" placeholder="Plat Kendaraan" id="no_kendaraan" name="no_kendaraan" required autofocus value="{{$tiket->no_kendaraan}}" />
                    </div>
                  </div>
                  <div class= "col-12">
                    <div class="input-style-1">
                      <label>Lokasi Sampah</label>
                      <input type="text" placeholder="Lokasi Asal Sampah" id="lokasi_sampah" name="lokasi_sampah" required autofocus value="{{$tiket->lokasi_sampah}}" />
                    </div>
                  </div>
                  <!-- end col -->
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>volume</label>
                      <input type="number" placeholder="volume" id="volume" name="volume" required autofocus value="{{$tiket->volume}}"/>
                    </div>
                  </div>
                    <button class="
                              main-btn
                              primary-btn
                              btn-hover
                              w-100
                              text-center
                             "type="submit">
                        Submit
                    </button>
        </div>
        <!-- end row -->
    </div>
</section>
@endsection

@push('js')
  @include('sweetalert::alert')
@endpush