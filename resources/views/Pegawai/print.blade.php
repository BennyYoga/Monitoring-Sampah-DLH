
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
    DATA PEGAWAI DLH
</h1>
<table class="table table-hover table-bordered table-stripped" id="pegawai">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Role</th>
                            <th>Kantor</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pegawai as $key => $pegawai)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$pegawai->NIP}}</td>
                                <td>{{$pegawai->nama_pegawai}}</td>
                                <td>{{$pegawai->id_role}}</td>
                                <td>{{$pegawai->id_kantor}}</td>
                            </tr>
                        @endforeach
                        </tbody>
</table>

