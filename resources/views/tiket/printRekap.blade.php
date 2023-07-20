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
            font-size: 8pt;
            border: 1px solid;
            padding: 0 2px;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="width:100%; text-align:center;">
        <h4><u>{{session('pegawai')->fk_kantor->nama_kantor}}</u></h4>
        {{session('pegawai')->fk_kantor->alamat_kantor}}
    </div>
    <br>
    @if($namakota == null)
    <h4>Data Sampah Wilayah Jawa Barat</h4>
    @else
    <h4>Data Sampah {{$namakota->nama_kab_kota}}</h4>
    @endif
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
                <td>{{ date('H:i:s', strtotime($data->jam_masuk)) }}</td>
                <td>{{ date('H:i:s', strtotime($data->jam_keluar)) }}</td>
                <td>{{$data->pengemudi}}</td>
                <td>{{$data->lokasi_sampah}}</td>
                <td>{{$data->volume}}</td>
                <td>0</td>
                <td>0</td> 
                <td>{{$data->volume * 476}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan='9'>Jumlah</td>
                <td>{{$total['Volume']}}</td>
                <td>0</td>
                <td>0</td>
                <td>{{$total['Tonase']}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
