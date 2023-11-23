@extends('Template.template')

@section('Pembelian Aset','Trash Monitoring System | Pembelian Aset')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .action {
        height: 55px;
        padding-left: 5px;
        padding-top: 15px;
    }

    .hapusItem {
        background: transparent;
        border: none;
        outline: none;
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
                    <h2>Tambah Pembelian Aset Barang Baru</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Pembelian Aset Barang</a>
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
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-style">
                            <form action="{{route('aset.pembelian.store')}}" method="post">
                                @csrf

                                <div class="row d-flex display-justify-content">
                                    <div class="col-sm-2 mt-3">
                                        <label>Tanggal Pembelian :</label>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="input-style-1">
                                            <input type="date" class="form-control @error('') is-invalid @enderror" id="" name="tanggalPembelian" value="" required />
                                            @error('') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-7">Nama Barang</div>
                                    <div class="col-sm-2">Unit</div>
                                    <div class="col-sm-2">Harga Satuan</div>
                                    <div class="col-sm-1">Action</div>
                                </div>
                                <hr>

                                <div class="dataItem" id="dataItemContainer">
                                    <div class="row">
                                        <div class="col-sm-7">
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
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="input-style-1">
                                                <input type="number" class="form-control @error('') is-invalid @enderror" name="Unit[]" value="" required min="1" />
                                                @error('') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <div class="input-style-1">
                                                <input type="number" class="form-control @error('') is-invalid @enderror" id="" name="Harga[]" value="" required min="1" />
                                                @error('') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-1">
                                            <div class="action">
                                                <button class="hapusItem">
                                                    <i class="lni lni-trash-can text-danger fs-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center mt-2">
                                    <button type="button" class="btn btn-primary" id="tambahItem">
                                        Tambah item
                                    </button>
                                </div>

                                <div class="d-flex justify-content-end mt-5">
                                    <a href="{{route('aset.pembelian.index')}}" class='btn danger-btn-outline m-1'>Batal</a>
                                    <button type='submit' class='btn btn-primary m-1'>Submit</button>
                                </div>
                            </form>
                        </div>
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
            <div class="row">
                                        <div class="col-sm-7">
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
                                        </div>
                                        
                                        <div class="col-sm-2">
                                        <div class="input-style-1">
                                        <input type="number" class="form-control @error('') is-invalid @enderror" name="Unit[]" value="" required min="1" />
                                        @error('') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                        </div>
                                        
                                                                                <div class="col-sm-2">
                                                                                    <div class="input-style-1">
                                                                                        <input type="number" class="form-control @error('') is-invalid @enderror" id="" name="Harga[]" value="" required min="1" />
                                                                                        @error('') <span class="text-danger">{{$message}}</span> @enderror
                                                                                    </div>
                                                                                </div>

                                        <div class="col-sm-1">
                                            <div class="action">
                                                <button class="hapusItem">
                                                    <i class="lni lni-trash-can text-danger fs-4"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
            `;

            $('#dataItemContainer').append(newRowHtml);

            // Generate a unique ID for the new select element
            const newSelectId = 'tags' + Date.now();
            $('#dataItemContainer .row:last-child .js-example-basic-single').attr('id', newSelectId);

            // Initialize Select2 for the newly added row
            $('#' + newSelectId).select2({
                theme: "classic",
            });
        });

        $('#dataItemContainer').on('click', '.hapusItem', function() {
            $(this).closest('.row').remove();
        });
    });
</script>

@endpush