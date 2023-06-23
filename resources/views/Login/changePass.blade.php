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
                    <h2>Change Passwod User</h2>
                </div>
            </div>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="Add">
                                Change Passwod
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->

            <form action="{{route('updatePassword', ['id'=>session('pegawai')->NIP])}}" method="POST" id="changepass">
                @csrf
                @method('POST')
                <div class="card-style mb-30">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-style-1">
                                <label>Masukkan Password Lama</label>
                                <input type="password" placeholder="Passwod Lama" name="PassLama"  required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="input-style-1">
                                <label>Masukkan Password Baru</label>
                                <input type="password" placeholder="Jenis Kendaraan" id="pass2" name="PassBaru" required />
                                <p id="message"></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-style-1">
                                <label>Confirm Passwod Baru</label>
                                <input type="password" id="pass1" require />
                                <p id="message"></p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <button class="main-btn primary-btn btn-hover w-100 text-center" type="submit" onclick="checkPassword()">
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
<script>
    function checkPassword(event) {
        let password1 = document.getElementById('pass1').value;
        let password2 = document.getElementById('pass2').value;
        let message = document.getElementById('message');

        if(password1.length != 0){
            if (password1 != password2) {
                message.textContent = 'Password Tidak Sesuai';
                message.style.color = 'red';
                event.preventDefault();
            }
        }
    }
    const form = document.getElementById('changepass');
    form.addEventListener('submit', checkPassword);
</script>
@endpush