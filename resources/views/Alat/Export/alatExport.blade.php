<!DOCTYPE html>
<html>
<head>
    <title>Data Alat Berat</title>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <!-- Tambahkan kolom lain sesuai kebutuhan -->
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
            <tr>
                <td>{{ $row['Nama'] }}</td>
                <td>{{ $row['Deskripsi'] }}</td>
                <!-- Tambahkan data lain sesuai kebutuhan -->
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
