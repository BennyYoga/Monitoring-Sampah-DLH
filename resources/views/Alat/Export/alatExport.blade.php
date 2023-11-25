<!DOCTYPE html>
<html>

<head>
    <title>Data Alat Berat</title>
</head>

<body>

    <table border="1" align="center" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th colspan="6" align="center" style="border: 1px solid #000; background-color: #f2f2f2;"><b>DAFTAR ALAT BERAT TPK SARIMUKTI</b></th>
            </tr>
            <tr>
                <th colspan="6"></th>
            </tr>
            <tr>
                <th colspan="6"></th>
            </tr>
            <tr>
                <th width="100px" align="center" style="border: 1px solid #000;">Kode</th>
                <th width="150px" align="center" style="border: 1px solid #000;">Merk</th>
                <th width="150px" align="center" style="border: 1px solid #000;">Model</th>
                <th width="150px" align="center" style="border: 1px solid #000;">NO SERI</th>
                <th width="150px" align="center" style="border: 1px solid #000;">TAHUN PEROLEHAN</th>
                <th width="300px" align="center" style="border: 1px solid #000;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $data)
            <tr>
                <td colspan="6" align="center" style="border: 1px solid #000; background-color: #d3d3d3;">{{$data->Nama}}</td>
            </tr>
            @foreach($data->alat->sort(function($a, $b) {
                // Custom sorting to handle alphanumeric strings
                $aNumeric = intval(preg_replace('/[^0-9]/', '', $a->Kode));
                $bNumeric = intval(preg_replace('/[^0-9]/', '', $b->Kode));

                if ($aNumeric == $bNumeric) {
                    return strnatcmp($a->Kode, $b->Kode);
                }

                return $aNumeric - $bNumeric;
            }) as $alat)
            <tr>
                <td align="center" style="border: 1px solid #000;">{{$alat->Kode}}</td>
                <td align="center" style="border: 1px solid #000;">{{$alat->Merk}}</td>
                <td align="center" style="border: 1px solid #000;">{{$alat->NamaModel}}</td>
                <td align="center" style="border: 1px solid #000;">{{$alat->NoSeri}}</td>
                <td align="center" style="border: 1px solid #000;">
                    {{date('F Y', strtotime($alat->TahunPerolehan))}}
                </td>
                <td align="center" style="border: 1px solid #000;">
                    @if($alat->Keterangan == 0)
                        Beroperasi
                    @elseif($alat->Keterangan == 1)
                        Beroperasi segera dilakukan perbaikan
                    @elseif($alat->Keterangan == 2)
                        Breakdown/dapat dilakukan perbaikan
                    @elseif($alat->Keterangan == 3)
                        Breakdown/rusak berat
                    @endif
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
