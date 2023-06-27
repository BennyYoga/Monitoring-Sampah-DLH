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
              <li class="breadcrumb-item active" aria-current="Add">
                Add
              </li>
            </ol>
          </nav>
        </div>
      </div>
      <!-- end col -->

      <form action="{{route('tiket.post')}}" method="POST">
        @csrf
        <div class="card-style mb-30">
          <div class="row">
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>Pengemudi</label>
                <input type="text" placeholder="Pengemudi" id="pengemudi" name="pengemudi" required autofocus />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>Jenis Kendaraan</label>
                <input type="text" placeholder="Jenis Kendaraan" id="jenis_kendaraan" name="jenis_kendaraan" required autofocus />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>Nomor Kendaraan</label>
                <input type="text" placeholder="Plat Nomor kendaraan" id="no_kendaraan" name="no_kendaraan" required autofocus />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>Lokasi Sampah</label>
                <input type="text" placeholder="Lokasi Asal Sampah" id="lokasi_sampah" name="lokasi_sampah" required autofocus />
              </div>
            </div>
          </div>
          <!-- end col -->
          <div class="row">
            <div class="col-sm-6">
              <div class="input-style-1">
                <label>volume</label>
                <input type="number" placeholder="volume" id="volume" name="volume" required autofocus />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="select-style-1">
                <label>Kabupaten/kota</label>
                <div class="select-position">
                  <select class="select2" name="id_kab_kota" id="id_kab_kota" style="width: 100%">
                  <option value=" " selected disabled> Pilih Kabupaten Kota </option>
                    @foreach($kabkota as $kabkota)
                    <option value="<?= $kabkota->id_kab_kota ?>">
                      <?= $kabkota->nama_kab_kota ?>
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <button class="main-btn primary-btn btn-hover w-100 text-center" type="submit">
            Submit
          </button>
        </div>
    </div>
    <!-- end row -->
  </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>
@endpush