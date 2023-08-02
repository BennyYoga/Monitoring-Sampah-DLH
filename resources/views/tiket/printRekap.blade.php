<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 10px;
        }
        
        table tr td,
        table tr th {
            font-size: 7pt;
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
        <b>{{session('pegawai')->fk_kantor->nama_kantor}}</b><br>
        {{session('pegawai')->fk_kantor->alamat_kantor}}

    </div>
    <br>
    <b>Data Sampah TPA Sari Mukti</b><br>
    @if($option->optionKota != 'undefined')
        Untuk Wilayah : {{$option->optionKota}} <br>
    @endif
    @if($option->optionHari != 'undefined')
        {{$option->optionHari}} <br>
    @endif
    <table>
        <thead>
            <tr>
                <td rowspan="2"><b>No.</b></td>
                <td rowspan="2"><b>No. Tiket</b></td>
                <td rowspan="2"><b>Tanggal</b></td>
                <td colspan="2"><b>Kendaraan</b></td>
                <td rowspan="2"><b>Kode Surat Jalan</b></td>
                <td colspan="2"><b>Jam</b></td>
                <td rowspan="2"><b>Nama Pengemudi</b></td>
                <td rowspan="2"><b>Lokasi Sumber Sampah</b></td>
                <td><b>Volume</b></td>
                <td colspan="3"><b>Berat</b></td>
                <td rowspan="2"><b>Total Biaya</b></td>
            </tr>
            <tr>
                <td><b>Nomor</b></td>
                <td><b>Jenis</b></td>
                <td><b>Masuk</b></td>
                <td><b>Keluar</b></td>
                <td><b>M3</b></td>
                <td><b>Bruto</b></td>
                <td><b>Tarra</b></td>
                <td><b>Netto</b></td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $data)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$data->id}}</td>
                <td>{{ date('d F Y', strtotime($data->jam_masuk)) }}</td>
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
                <td>{{$data->tonase}}</td>
                <td>Rp. {{number_format($data->tonase*50)}}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan='10'>Jumlah</td>
                <td>{{$total['Volume']}}</td>
                <td>0</td>
                <td>0</td>
                <td>{{$total['Tonase']}}</td>
                <td>Rp. {{number_format($total['Tonase']*50)}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
