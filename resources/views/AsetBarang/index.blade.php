@extends('Template.template')

@section('Aset Barang','Trash Monitoring System | Aset Barang')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<style>
    .text-center {
        text-align: center !important;
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
                    {{-- @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                </div>
                @endif --}}
                <div class="title mb-30">
                    <h2>Aset Barang</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Aset Barang</a>
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

        <!-- star Row -->
        <div class="tables-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <div class="table-wrapper table-responsive">
                            <table class="table" id="AsetBarang">
                                <a href="" onClick="notificationAddBarang(event,this)" class="btn btn-primary mb-3">
                                    Tambah Barang
                                </a>
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Satuan</th>
                                        <th>Total Unit</th>
                                        <th>Jenis Barang</th>
                                        <th>Kategori Bahan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</section>


<!-- Modals Delete -->
<div id="modalDelete" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Delete Barang</h5>
            </div>
            <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin menghapus Barang ini?</p>

                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <a href="" class="btn btn-primary ml-5" id="deleteSubmit">Submit</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- modals Create -->
<div id="add-barang" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="add-barang" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Tambah Data Barang</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('aset.barang.store')}}" id="form" method="POST">
                    @csrf
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-style-1">
                                    <label>Nama Barang</label>
                                    <input type="text" placeholder="Masukkan Nama Barang" class="form-control @error('NamaBarang') is-invalid @enderror" name="NamaBarang" value="" required />
                                    @error('NamaBarang') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div id="input-jenis-barang" class="col-sm-6">
                                <div class="select-style-1">
                                    <label>Jenis Barang</label>
                                    <div class="select-position">
                                        <select name="JenisBahan" class="JenisBahan" style="width: 100%">
                                            <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                            @foreach ($jenisBarang as $item)
                                            <option value="{{$item}}">{{$item->Nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-style-1">
                                    <label>Satuan</label>
                                    <input type="text" placeholder="Masukkan Jenis Satuan" class="form-control @error('SatuanBarang') is-invalid @enderror" name="SatuanBarang" value="" required />
                                    @error('SatuanBarang') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 d-none AlatBeratControl">
                                <div class="select-style-1">
                                    <label>Nama Alat Berat</label>
                                    <div class="select-position">
                                        <select name="AlatBerat" id="AlatBerat" style="width: 100%">
                                            <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                            @foreach ($alat as $item)
                                            <option value="{{$item->AlatUuid}}">{{$item->Jenis->Nama}} - {{$item->NamaModel}} - {{$item->NoSeri}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" data-bs-dismiss="modal" class='btn danger-btn-outline m-1'>Batal</button>
                        <button type='submit' class='btn btn-primary m-1'>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- modals Create -->
<div id="edit-barang" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="edit-barang" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Edit Data Barang</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('aset.barang.update')}}" id="form" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="BarangUuid" value="">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-style-1">
                                    <label>Nama Barang</label>
                                    <input type="text" placeholder="Masukkan Nama Barang" class="form-control @error('NamaBarang') is-invalid @enderror" name="NamaBarang" value="" required />
                                    @error('NamaBarang') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div id="input-jenis-barang" class="col-sm-6">
                                <div class="select-style-1">
                                    <label>Jenis Barang</label>
                                    <div class="select-position">
                                        <select name="JenisBahan" class="JenisBahan" style="width: 100%">
                                            <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                            @foreach ($jenisBarang as $item)
                                            <option value="{{$item}}">{{$item->Nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-style-1">
                                    <label>Satuan</label>
                                    <input type="text" placeholder="Masukkan Jenis Satuan" class="form-control @error('SatuanBarang') is-invalid @enderror" name="SatuanBarang" value="" required />
                                    @error('SatuanBarang') <span class="text-danger">{{$message}}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 d-none AlatBeratControl">
                                <div class="select-style-1">
                                    <label>Nama Alat Berat</label>
                                    <div class="select-position">
                                        <select name="AlatBerat" id="AlatBerat" style="width: 100%">
                                            <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                            @foreach ($alat as $item)
                                            <option value="{{$item->AlatUuid}}">{{$item->Jenis->Nama}} - {{$item->NamaModel}} - {{$item->NoSeri}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" data-bs-dismiss="modal" class='btn danger-btn-outline m-1'>Batal</button>
                        <button type='submit' class='btn btn-primary m-1'>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        {
            $('#modalDelete').modal('show');
            $("#deleteSubmit").attr('href', $(el).attr('href'));
        }
    }

    function notificationAddBarang(event, el) {
        event.preventDefault();
        {
            
            let ControlAlatBerat = $('.AlatBeratControl');
            ControlAlatBerat.addClass('d-none');    
            $('input[name="BarangUuid"]').val(null);
            $('input[name="NamaBarang"]').val(null);
            $('input[name="SatuanBarang"]').val(null);
            $('select[name="JenisBahan"]').val('-');
            $('select[name="AlatBerat"').val('-');

            $('#add-barang').modal('show');
        }
    }

    function notificationEdit(event, el) {
        event.preventDefault();
        {
            let data = JSON.parse(el.getAttribute('data-id'));
            $('input[name="BarangUuid"]').val(data.BarangUuid);
            $('input[name="NamaBarang"]').val(data.Nama);
            $('input[name="SatuanBarang"]').val(data.Satuan);
            
            let jenis_aset = JSON.stringify(data.aset_jenis);
            $('select[name="JenisBahan"]').val(jenis_aset);

            let ControlAlatBerat = $('.AlatBeratControl');
            if(data.aset_jenis.Bahan == 3){
                $('select[name="AlatBerat"').val(data.AlatBeratId);
                ControlAlatBerat.removeClass('d-none');
            }
            else{
                ControlAlatBerat.addClass('d-none');    
            }

            $('#edit-barang').modal('show');
        }
    }

    $(document).ready(function() {
        var table = $('#AsetBarang').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [{
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    name: 'Nama',
                    data: 'Nama',

                },
                {
                    name: 'Satuan',
                    data: 'Satuan',
                },
                {
                    data: 'TotalUnit',
                    name: 'TotalUnit',
                },
                {
                    data: 'Jenis',
                    name: 'Jenis',
                },
                {
                    data: 'Bahan',
                    name: 'Bahan',
                },
                {
                    data: 'action',
                    name: 'action',
                    "className": "text-center"
                },
            ],
            order: [
                [
                    1, 'asc'
                ]
            ]
        });

        $('.JenisBahan').on('change', function(){
            var pilihan = JSON.parse($(this).val());
            let ControlAlatBerat = $('.AlatBeratControl');
            if(pilihan.Bahan == 3){
                ControlAlatBerat.removeClass('d-none');
            }
            else{
                ControlAlatBerat.addClass('d-none');
            }
        });
    });
</script>
@endpush