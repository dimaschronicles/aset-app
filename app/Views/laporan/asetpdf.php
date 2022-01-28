<html>

<head>
    <title>Laporan Aset</title>
    <style>
        h1 {
            text-align: center;
            font-family: sans-serif;
            font-size: 18px;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Data Aset PT. Satria Dirgantara</h1>

    <p><b>Tanggal Download</b> : <?= date('Y-m-d'); ?></p>

    <table width="100%">
        <tr>
            <td width="25" align="center"><img src="Tes.jpg" width="60%"></td>
            <td width="50" align="center">
                <h1>Gemscool Game Portal Pertama Indonesia</h1><br>
                <h2>Jakarta</h2>
            </td>
            <td width="25" align="center"><img src="Logo DN.jpg" width="100%"></td>
        </tr>
    </table>
    <hr>

    <table>
        <tr style="background-color: cornflowerblue">
            <th width="6%">No</th>
            <th width="30%">Nama Barang</th>
            <th width="6%">Jumlah</th>
            <th width="10%">Kondisi</th>
            <th>Lokasi</th>
            <th>Nilai</th>
            <th>Penginput</th>
        </tr>
        <?php $i = 1;
        foreach ($aset as $a) : ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= $a['nama_barang']; ?></td>
                <td><?= $a['jumlah']; ?></td>
                <td><?= $a['kondisi']; ?></td>
                <td><?= $a['nama_ruangan']; ?></td>
                <td><?= number_format($a['nilai_aset'], 0, ".", ".") ?></td>
                <td><?= $a['user_penginput']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>