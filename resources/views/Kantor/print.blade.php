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
        <h4>Data Kantor DLH Jawa Barat</h4>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Nama TPA</td>
                <td>Alamat</td>
            </tr>
        </thead>
        <tbody>
            @foreach($kantor as $key => $kantor)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$kantor->nama_kantor}}</td>
                <td>{{$kantor->alamat_kantor}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>