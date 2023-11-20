@extends('Template.template')

@section('Pemakaian Aset','Trash Monitoring System | Pemakaian Aset')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .action {
        justify-content: center;
        flex-direction: column-reverse;
        top: -12px;
        position: relative;
    }

    .input-tags {
        width: 100%;
        border-radius: 4px;
        color: #5d657b;
        resize: none;
        transition: all 0.3s;
    }

    .input-tags .selection {
        width: 100%;
        background: rgba(239, 239, 239, 0.5);
    }

    .input-tags input {
        display: none;
    }

    .input-tags .selection>span {
        margin-top: 2px;
        border: 1px solid #e5e5e5;
        padding: 28px !important;
        background: transparent;
    }

    .select2-container--classic .select2-selection--single .select2-selection__rendered {
        line-height: 16px !important;
        top: 22px;
        position: absolute;
    }


    td.min-width {
        min-width: 10px;
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
                    <h2>Tambah Pemakaian Aset Barang Baru</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Pemakaian Aset Barang</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Create
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

        <div class="tables-wrapper">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-style">
                        <div class="row">
                            <div class="col-sm-6">
                                Tanggal Pemakaian : {{date('d F Y')}}
                            </div>
                            <div class="col-sm-6 text-end">
                                <button class="btn btn-primary" id="tambahItem">
                                    Tambah item
                                </button>
                            </div>
                        </div>

                        <form action="{{route('aset.pemakaian.store')}}" method="post">
                            @csrf
                            <table class="table Tabel-Item mt-5">
                                <thead>
                                    <tr>
                                        <th width="65%">
                                            <h6>Nama Barang</h6>
                                        </th>
                                        <th width="25%">
                                            <h6>Unit</h6>
                                        </th>
                                        <th width="10%">
                                            <h6>Action</h6>
                                        </th>
                                    </tr>
                                    <!-- end table row-->
                                </thead>
                                <tbody>
                                    <tr class="dataItem">
                                        <td height="10" class="min-width">
                                            <div class="select-sm select-style-1">
                                                <div class="select-position input-tags">
                                                    <select class="js-example-basic-single form-" id="tags" name="Barang[]">
                                                        <option value="-" selected disabled>Pilih Barang yang Dibeli</option>
                                                        @foreach ($barang as $item)
                                                        @if ($item->AlatBeratId)
                                                        <option value="{{$item->BarangUuid}}">{{$item->Nama}} - {{$item->Alat->Merk}} {{$item->Alat->NamaModel}} ({{$item->TotalUnit}})</option>
                                                        @else
                                                        <option value="{{$item->BarangUuid}}">{{$item->Nama}} ({{$item->TotalUnit}})</option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                        <td height="10" class="min-width">
                                            <div class="input-style-1">
                                                <input type="number" class="form-control @error('') is-invalid @enderror" id="" name="Unit[]" value="" required min="1"/>
                                                @error('') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action">
                                                <button class="text-danger hapusItem">
                                                    <i class="lni lni-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end mt-5">
                                <a href="{{route('aset.pemakaian.index')}}" class='btn danger-btn-outline m-1'>Batal</a>
                                <button type='submit' class='btn btn-primary m-1'>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize Select2 for the initial row
        $('.js-example-basic-single').select2({
            theme: "classic",
        });

        $('#tambahItem').click(function() {
            const newRowHtml = `
                <tr class="dataItem">
                    <td height="10" class="min-width">
                        <div class="select-sm select-style-1">
                            <div class="select-position input-tags">
                                <select class="js-example-basic-single form-" name="Barang[]">
                                    <option value="-" selected disabled>Pilih Barang yang Dibeli</option>
                                    @foreach ($barang as $item)
                                    @if ($item->AlatBeratId)
                                    <option value="{{$item->BarangUuid}}">{{$item->Nama}} - {{$item->Alat->Merk}} {{$item->Alat->NamaModel}} ({{$item->TotalUnit}})</option>
                                    @else
                                    <option value="{{$item->BarangUuid}}">{{$item->Nama}} ({{$item->TotalUnit}})</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </td>
                    <td height="10" class="min-width">
                        <div class="input-style-1">
                            <input type="number" class="form-control @error('') is-invalid @enderror" name="Unit[]" value="" required/>
                            @error('') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="action">
                            <button class="text-danger hapusItem">
                                <i class="lni lni-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;

            // Append the new row HTML to the table
            $('.Tabel-Item tbody').append(newRowHtml);

            // Initialize Select2 for the newly added row
            $('.Tabel-Item tbody tr:last-child .js-example-basic-single').select2({
                theme: "classic",
            });
        });

        $('.Tabel-Item').on('click', '.hapusItem', function() {
            $(this).closest('tr').remove();
            updateRowNumbers();
        });
    });
</script>

@endpush