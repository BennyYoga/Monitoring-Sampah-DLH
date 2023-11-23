@extends('Template.template')

@section('Jenis Aset','Trash Monitoring System | Kondisi Alat')

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
                    <h2>Jenis Aset</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Jenis Aset</a>
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
                            <table class="table" id="AsetJenis">
                                <div class="row">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <a href="" onClick="notificationAddJenis(event,this)" class="btn btn-primary mb-3">
                                            Tambah Jenis
                                        </a>
                                    </div>
                                </div>
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Jenis Kategori</th>
                                        <th>Jenis Bahan</th>
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
</section>

<!-- modals add aset jenis -->
<div id="add-jenis" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="add-jenis" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Tambah Kondisi Alat</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('aset.jenis.store')}}" id="form" method="POST">
                    @csrf
                    <div class="content">
                        <div class="select-style-1">
                            <label>Jenis Bahan</label>
                            <div class="select-position">
                                <select name="Bahan" id="Bahan" style="width: 100%">
                                    <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                    <option value="0">BAHAN BANGUNAN DAN KONSTRUKSI</option>
                                    <option value="1">BAHAN KIMIA</option>
                                    <option value="2">ALAT/BAHAN UNTUK KEGIATAN KANTOR</option>
                                    <option value="3">SUKU CADANG</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-style-1">
                            <label>Nama Jenis Aset</label>
                            <input type="text" placeholder="Nama Jenis Aset" class="form-control @error('Nama_Jenis') is-invalid @enderror" name="Nama_Jenis" value="" required />
                            @error('Nama_Jenis') <span class="text-danger">{{$message}}</span> @enderror
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

<!-- Modals Delete -->
<div id="modalDelete" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Delete Jenis Aset</h5>
            </div>
            <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin menghapus data jenis aset ini?</p>

                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <a href="" class="btn btn-primary ml-5" id="deleteSubmit">Submit</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modals Edit -->
<div id="edit-jenis-aset" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="edit-jenis-aset" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Edit Jenis Alat Berat</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('aset.jenis.update')}}" id="form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="content">
                        <div class="select-style-1">
                            <label>Jenis Bahan</label>
                            <div class="select-position">
                                <select name="Bahan" id="Bahan" style="width: 100%">
                                    <option value="-" selected disabled> Pilih Jenis Alat Berat </option>
                                    <option value="0">BAHAN BANGUNAN DAN KONSTRUKSI</option>
                                    <option value="1">BAHAN KIMIA</option>
                                    <option value="2">ALAT/BAHAN UNTUK KEGIATAN KANTOR</option>
                                    <option value="3">SUKU CADANG</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" value="" id="KondisiId" name="KondisiId">
                        <div class="input-style-1">
                            <label>Nama Jenis Aset</label>
                            <input type="text" placeholder="Nama Jenis Aset" class="form-control @error('Nama_Jenis') is-invalid @enderror" name="Nama_Jenis" value="" required />
                            @error('Nama_Jenis') <span class="text-danger">{{$message}}</span> @enderror
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
    function notificationAddJenis(event, el) {
        event.preventDefault();
        {
            $('input[name=Nama_Jenis]').val(null);
            $('select[name=Bahan]').val('-');
            $('#add-jenis').modal('show');
        }
    }

    function notificationBeforeDelete(event, el) {
        event.preventDefault();
        {
            $('#modalDelete').modal('show');
            $("#deleteSubmit").attr('href', $(el).attr('href'));
        }
    }

    function notificationEdit(event, el) {
        event.preventDefault();
        {
            let data = JSON.parse(el.getAttribute('data-id'));
            
            $('input[name=KondisiId]').val(`${data.Id}`);
            $('select[name=Bahan]').val(`${data.Bahan}`);
            $('input[name=Nama_Jenis]').val(`${data.Nama}`);

            $('#edit-jenis-aset').modal('show');
            $("#form").attr('action', $(el).attr('href'));
        }
    }

    $(document).ready(function() {
        var table = $('#AsetJenis').DataTable({
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
                    data: 'Nama',
                    name: 'Nama',
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
    });
</script>
@endpush