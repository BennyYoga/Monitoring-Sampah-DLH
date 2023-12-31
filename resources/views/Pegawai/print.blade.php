<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr td,
        table tr th {
            font-size: 9pt;
            border: 1px solid;
            padding: 5px;
            text-align: left
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="width:100%; text-align:center;">
        <h4>Data Pegawai DLH Jawa Barat</h4>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Pegawai</td>
                <td>NIP</td>
                <td>Kantor</td>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $key => $pegawai)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$pegawai->nama_pegawai}}</td>
                <td>{{$pegawai->NIP}}</td>
                <td>{{$pegawai->fk_kantor->nama_kantor}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>