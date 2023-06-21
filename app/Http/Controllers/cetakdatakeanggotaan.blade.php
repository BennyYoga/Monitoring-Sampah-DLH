
<style>
    table{
        width:100%;
        border-collapse:"collapse";
    }
    table tr td, table tr th{
        font-size: 9pt;
        border:1px solid;
    }
    .centered {
        text-align:center;
    }
    td{
        padding-left:10px;
    }
    h1{
        text-align:center;
    }
</style>
<h1>
    DATA KEANGGOTAAN PERPUSTAKAAN
</h1>
<table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Nama Depan</th>
                            <th>Nama Belakang</th>
                            <th>Pekerjaan</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Nomor Handphone</th>
                            <th>Jenis Kelamin</th>
                           
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data_keanggotaan as $key => $data_keanggotaan)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data_keanggotaan->NIK}}</td>
                                <td>{{$data_keanggotaan->nama_depan}}</td>
                                <td>{{$data_keanggotaan->nama_belakang}}</td>
                                <td>{{$data_keanggotaan->pekerjaan}}</td>
                                <td>{{$data_keanggotaan->tempat_lahir}}</td>
                                <td>{{$data_keanggotaan->tanggal_lahir}}</td>
                                <td>{{$data_keanggotaan->alamat}}</td>
                                <td>{{$data_keanggotaan->no_hp}}</td>
                                <td>{{$data_keanggotaan->jenis_kelamin}}</td>
                               
                            </tr>
                        @endforeach
                        </tbody>
</table>

