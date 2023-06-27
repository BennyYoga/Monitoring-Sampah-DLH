<!DOCTYPE html>
<html>
<head>
    <title>Bukti Transaksi {{$tiket->pengemudi}}</title>
    <style>
        /* Gaya untuk logo */
        .logo {
            width: 60px;
            height: 31px;
            background-position: left top;
            background-repeat: no-repeat; 
            background-size: cover;
            margin-top: 2px;
        }

        /* Gaya untuk header */
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-top: 5px;
            margin-bottom: 5px;
            border-bottom: 0.5px solid black; /* Menambahkan garis pembatas */
            padding-bottom: 2px;
        }

        /* Gaya untuk tanda tangan */
        .signature {
            text-align: right;
            margin-top: 5px;
            font-size: 10px;
            border-bottom: 0.5px dashed black;
        }
        .h6{
            display: block;
            font-size: .50em;
            margin-top: .33em;
            margin-bottom: .33em;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;
        }
        /* Gaya tambahan */
        .text-center {
            text-align: center;
            margin: 2px 0;
        }
    </style>
</head>
<body>
<?php for ($i = 0; $i < 2; $i++) { ?>
    <div class="header">
        <!-- <div class="logo" style="background-image: url('images/logo/absensi.png')"></div> -->
        <p class="h6">SISTEM MONITORING SAMPAH</p>
        <p class="h6">PEMERINTAH DAERAH PROVINSI JAWA BARAT</p>
        <p class="h6">DINAS LINGKUNGAN HIDUP</p>
        <p class="h6">UPTD PENGELOLAAN SAMPAH TPA/TPST REGIONAL</p>
        <p class="h6">bentar</p>
    </div>
    <div class="h6">
        <p class="text-center">TANDA TERIMA</p>
        <p class="text-center" style="padding-bottom:5px">HASIL KERJA</p>
    </div>
    <div>
        <table cellspacing='0' cellpadding='0' style='width: 350px; font-size: 10px; font-family: Verdana, Arial, sans-serif;'>
            <tr>
                <td colspan='4' style='text-align: left'>Tanggal</td>
                <td style='text-align: left; font-size: 10px;'>:{{ $tiket->jam_keluar->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Nomor Kendaraan</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{$tiket->no_kendaraan}}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Nama Pengemudi</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{$tiket->pengemudi}}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Jam Masuk</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{ date('H:i:s', strtotime($tiket->jam_masuk)) }}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Jam Keluar</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{ $tiket->jam_keluar->format('H:i:s') }}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Lokasi</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{$tiket->lokasi_sampah}}</td>
            </tr>
            <tr>
                <td colspan='4' style='text-align: left; color: black'>Volume (Kg)</td>
                <td style='text-align: left; font-size: 10px; color: black'>: {{$tiket->volume}}</td>
            </tr>
        </table>
    </div>
    <div class="signature">
        <p style="text-align: left;margin-bottom:0.5px; margin-top:5px;">Mengetahui</p> 
        <p>Pencatat</p><br><br>
        <p style="font-size: 10px;"><b>{{$user->nama_pegawai}}</p>
    </div>
    <?php } ?>
</body>
@if(session('refresh'))
    <script>
        setTimeout(function () {
            location.reload();
        }, 2000); // Setelah 2 detik, halaman akan direfresh
    </script>
@endif

</html>
