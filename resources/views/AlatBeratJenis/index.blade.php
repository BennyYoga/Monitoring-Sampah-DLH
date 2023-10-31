@extends('Template.template')

@section('Jenis Alat Berat','Trash Monitoring System | Jenis Alat Berat')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
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
                <div class="title mb-30">
                    <h2>Jenis Alat Berat</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Jenis Alat Berat</a>
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
                            <table class="table" id="jenisAlat">
                                <a href="" onClick="notificationAddAlat(event,this)" class="btn btn-primary mb-3">
                                    Tambah Jenis Alat
                                </a>
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Kode Alat Berat</th>
                                        <th>Nama Alat Berat</th>
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


<div id="add-jenis-alat" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="add-jenis-alat" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Tambah Jenis Alat Berat Baru</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('jenisalat.store')}}" id="form" method="POST">
                    @csrf
                    <div class="content">
                        <div class="input-style-1">
                            <label>Kode Alat Berat</label>
                            <input type="text" placeholder="Kode dari Alat Berat" class="form-control @error('Kode') is-invalid @enderror" name="Kode" value="" required />
                            @error('Kode') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="input-style-1">
                            <label>Nama Jenis Alat</label>
                            <input type="text" placeholder="Nama Alat Berat" class="form-control @error('Nama') is-invalid @enderror" name="Nama" value="" required />
                            @error('Nama') <span class="text-danger">{{$message}}</span> @enderror
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

<div id="edit-jenis-alat" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="edit-jenis-alat" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Edit Jenis Alat Berat</h5>
            </div>
            <div class="modal-body px-0">
                <form action="{{route('jenisalat.update')}}" id="form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="content">
                        <input type="hidden" name="JenisAlatBeratId" value="">
                        <div class="input-style-1">
                            <label>Kode Alat Berat</label>
                            <input type="text" placeholder="Kode dari Alat Berat" class="form-control @error('Kode') is-invalid @enderror" name="Kode" value="" required />
                            @error('Kode') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="input-style-1">
                            <label>Nama Jenis Alat</label>
                            <input type="text" placeholder="Nama Alat Berat" class="form-control @error('Nama') is-invalid @enderror" name="Nama" value="" required />
                            @error('Nama') <span class="text-danger">{{$message}}</span> @enderror
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

<div id="modalDelete" class="modal fade bd-example-modal-mb" tabindex="-1" role="dialog" aria-labelledby="add-categori" aria-hidden="true">
    <div class="modal-dialog modal-mb modal-dialog-centered">
        <div class="modal-content card-style ">
            <div class="modal-header px-0">
                <h5 class="text-bold" id="exampleModalLabel">Delete Jenis Alat Berat</h5>
            </div>
            <div class="modal-body px-0">
                <p class="mb-40">Apakah anda yakin ingin menghapus data jenis alat berat ini ini?</p>

                <div class="action d-flex flex-wrap justify-content-end">
                    <button class="btn btn-outline-danger" data-bs-dismiss="modal">Batal</button>
                    <a href="" class="btn btn-primary ml-5" id="deleteSubmit">Submit</a>
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
    function notificationAddAlat(event, el) {
        event.preventDefault();
        {
            $('input[name=Nama]').val(null);
            $('input[name=Kode]').val(null);
            $('#add-jenis-alat').modal('show');
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

            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    data[key] = data[key].replace(/-/g, ' ');
                }
            }

            $('input[name=JenisAlatBeratId]').val(`${data.JenisAlatBeratId}`);
            $('input[name=Nama]').val(`${data.Nama}`);
            $('input[name=Kode]').val(`${data.Kode}`);

            $('#edit-jenis-alat').modal('show');
            $("#form").attr('action', $(el).attr('href'));
        }
    }

    $(document).ready(function() {
        var table = $('#jenisAlat').DataTable({
            processing: true,
            serverSide: true,
            ajax: "",
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'Kode',
                },
                {
                    data: 'Nama',
                },
                {
                    data: 'action',
                    name: 'action',
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