<html>

<head>
    <style>
        h1 {
            text-align: center;
            font-family: sans-serif;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h1>PT. SATRIA DIRGANTARA</h1>
    <hr>
    <h3>Daftar Aset</h3>
    <table>
        <tr>
            <th><b>No</b></th>
            <th><b>Kode Aset</b></th>
            <th><b>Kode Lokasi</b></th>
            <th><b>Kode Ruang</b></th>
            <th><b>Kondisi Aset</b></th>
            <th><b>Sumber</b></th>
            <th><b>Tahun Pengadaan</b></th>
            <th><b>QR Code</b></th>
        </tr>
        <?php $i = 1;
        foreach ($barang as $b) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $b['kode_barang']; ?></td>
                <td><?= $b['kode_lokasi']; ?></td>
                <td><?= $b['kode_ruang']; ?></td>
                <td><?= $b['kondisi_aset']; ?></td>
                <td><?= $b['sumber_pengadaan']; ?></td>
                <td><?= $b['tanggal_pengadaan']; ?></td>
                <td><img src="/img/aset/qr/<?= $b['qr_code'] . '.png'; ?>" width="100px"></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>