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
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>DATA KEANGGOTAAN PERPUSTAKAAN</h1>
    <table>
        <thead>
            <tr>
                <td rowspan="2">No.</td>
                <td rowspan="2">No. Tiket</td>
                <td colspan="2">Kendaraan</td>
                <td rowspan="2">Kode Surat Jalan</td>
                <td colspan="2">Jam</td>
                <td rowspan="2">Nama Pengemudi</td>
                <td rowspan="2">Lokasi Sumber Sampah</td>
                <td>Volume</td>
                <td colspan="3">Berat</td>
            </tr>
            <tr>
                <td>Nomor</td>
                <td>Jenis</td>
                <td>Masuk</td>
                <td>Keluar</td>
                <td>M3</td>
                <td>Bruto</td>
                <td>Tarra</td>
                <td>Netto</td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->id}}</td>
                <td>{{$data->no_kendaraan}}</td>
                <td>{{$data->jenis_kendaraan}}</td>
                <td>-</td>
                <td>{{$data->jam_masuk}}</td>
                <td>{{$data->jam_keluar}}</td>
                <td>{{$data->pengemudi}}</td>
                <td>{{$data->fk_kab_kot->nama_kab_kota}}</td>
                <td>{{$data->volume}}</td>
                <td>0</td>
                <td>0</td>
                <td>{{$data->volume * 476}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>