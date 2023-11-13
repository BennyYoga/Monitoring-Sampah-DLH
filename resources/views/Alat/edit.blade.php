@extends('Template.template')

@section('Alat','Trash Monitoring System | alat')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<style>
    .canvas{
        width: 100%;
        border: 2px solid #e5e5e5;
        padding: 15px 0px;
        border-radius: 5px;
        background: rgba(239, 239, 239, 0.5);
    }
    #imagePreview {
        height: 200px;
        width: 350px;
        object-fit: cover;
        border-radius: 5px;
    }

    .input-tags {
        width: 100%;
        border-radius: 4px;
        padding: 0px;
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
        border: 1px solid #e5e5e5;
        padding: 16px !important;
        background: transparent;
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
                    <h2>Edit Data Alat Berat</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Alat</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Edit
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
                <div class="col-lg-12">
                    <div class="card-style mb-30">
                        <form action="{{route('alat.update', $alat->AlatUuid)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="select-style-1">
                                        <label>Jenis Alat Berat</label>
                                        <div class="select-position">
                                            <select class="select" name="JenisAlatBeratId" id="JenisAlatBeratId" style="width: 100%" disabled>
                                                <option value="">{{$jenis_alat_berat->Nama}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-style-1">
                                        <label>Merek Alat Berat</label>
                                        <input type="text" placeholder="Masukkan Nama Merek Alat Berat" class="form-control @error('Merk') is-invalid @enderror" name="Merk" value="{{$alat->Merk}}" required />
                                        @error('Merk') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-style-1">
                                        <label>Nomor Seri Alat Berat</label>
                                        <input type="text" placeholder="Masukkan Nomor Seri Alat Berat" class="form-control @error('NoSeri') is-invalid @enderror" name="NoSeri" value="{{$alat->NoSeri}}" required />
                                        @error('NoSeri') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-style-1">
                                        <label>Model Alat Berat</label>
                                        <input type="text" placeholder="Masukkan Nama Model Alat Berat" class="form-control @error('NamaModel') is-invalid @enderror" name="NamaModel" value="{{$alat->NamaModel}}" required />
                                        @error('NamaModel') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="canvas text-center">
                                        <img  src="{{asset($alat->Foto)}}" onerror="this.src='{{asset('images/defaultImage.png')}}'" id="imagePreview" alt="">
                                    </div>
                                    <div class="input-style-1 mt-4">
                                        <label>Foto Alat Berat</label>
                                        <input type="file" class="form-control @error('Foto') is-invalid @enderror" id="FotoAlatBerat" name="Foto" value="{{old('Foto')}}" accept=".png, .jpg, .jpeg"/>
                                        @error('NoSeri') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-style-1">
                                        <label>Tahun Perolehan Alat Berat</label>
                                        <input type="month" value="{{$alat->TahunPerolehan}}" placeholder="Masukkan Tahun Perolehan Alat Berat" class="form-control @error('TahunPerolehan') is-invalid @enderror" name="TahunPerolehan" value="{{old('TahunPerolehan')}}" required />
                                        @error('TahunPerolehan') <span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                    <div class="select-style-1">
                                        <label>Keterangan</label>
                                        <div class="select-position">
                                            <select class="select" value="{{old('Keterangan')}}" name="Keterangan" id="Keterangan" style="width: 100%">
                                                <option value="0" @if ($alat->Keterangan == 0) selected @endif>Beroperasi</option>
                                                <option value="1" @if ($alat->Keterangan == 1) selected @endif>Beroperasi segera dilakukan perbaikan</option>
                                                <option value="2" @if ($alat->Keterangan == 2) selected @endif>Breakdown/dapat dilakukan perbaikan</option>
                                                <option value="3" @if ($alat->Keterangan == 3) selected @endif>Breakdown/rusak berat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="select-sm select-style-1">
                                        <label>Kondisi Alat Berat</label>
                                        <div class="select-position input-tags">
                                            <select class="js-example-basic-single form-" id="tags" multiple name="Kondisi[]">
                                                @foreach($dataKondisi as $value)
                                                <option value="<?= $value['KondisiId'] ?>" @if($value['selected'] == true) selected @endif>{{$value['Label']}}</option>
                                                @endforeach
                                            </select>
                                            @error('Kondisi') <span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{route('alat.index')}}" class='btn danger-btn-outline m-1'>Batal</a>
                                    <button type='submit' class='btn btn-primary m-1'>Submit</button>
                                </div>
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
        $('.js-example-basic-single').select2({
            theme: "classic",
        });
        $('#tags').on("select2:open", () => {
            $(".input-tags .selection").css("background", "rgba(0,0,0,0)")
        }).on("select2:close", () => {
            $(".input-tags .selection").css("background", "rgba(239, 239, 239, 0.5)")
        })
    });

    $("#FotoAlatBerat").change(function(e) {
        let file = e.target.files[0];
        if (file) {
            var formData = new FormData();
            formData.append('file', file);
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }),
                $.ajax({
                    url: "{{ route('alat.create.uploadImage') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#imagePreview").attr("src", `{{asset('images/temp/${data.success}')}}`);
                    },
                    error: function(data) {
                        console.log("Gagal mengunggah file:", data.responseText);
                    }
                });
        }
    });
</script>
@endpush