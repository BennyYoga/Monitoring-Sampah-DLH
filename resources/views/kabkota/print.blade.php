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
        <h4>Data Kabupaten / Kota DLH Jawa Barat</h4>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Kabupaten / kota</td>
            </tr>
        </thead>
        <tbody>
            @foreach($kabkota as $key => $kabkota)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$kabkota->nama_kab_kota}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>