<html>

<head>
    <style>
        .print {
            margin: auto;
            width: 100%;
            height: 100%;
        }

        .h2 {
            text-align: center;
        }

        .h3 {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">
        PT SATRIA DIRGANTARA
    </h1>
    <p style="text-align: center; margin: 0px 0px 0px 0px;">Perumahan Mutiara Pratama A-9, RT06/RW02, Berkoh, <br> Purwokerto Selatan, Banyumas, Jawa Tengah, (53146) <br>Telp. WA : 081227130002</p>
    <hr style="margin-bottom: 20%;">

    <?php
    if (empty($transaksi)) : ?>
        <?php if ($jenis == "Aset Masuk") : ?>
            <?php
            $tgl_dari = @$_GET['tanggal_dari'];
            $tgl_sampai = @$_GET['tanggal_sampai'];
            $jenis = @$_GET['jenis'];
            ?>

            <table class="table">
                <tr>
                    <th width="30%">Dari Tanggal</th>
                    <th width="1%">:</th>
                    <td><?= $tgl_dari; ?></td>
                </tr>
                <tr>
                    <th>Sampai Tanggal</th>
                    <th>:</th>
                    <td><?= $tgl_sampai; ?></td>
                </tr>
                <tr>
                    <th>Jenis</th>
                    <th>:</th>
                    <td><?= $jenis; ?></td>
                </tr>
            </table>

            <br>

            <table border="1" class="print">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Masuk</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($aset as $am) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $am['nama_barang']; ?></td>
                            <td><?= $am['tanggal_masuk']; ?></td>
                            <td><?= $am['jumlah']; ?></td>
                            <td><?= $am['keterangan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($jenis == "Aset Keluar") : ?>
            <?php
            $tgl_dari = @$_GET['tanggal_dari'];
            $tgl_sampai = @$_GET['tanggal_sampai'];
            $jenis = @$_GET['jenis'];
            ?>

            <table class="table">
                <tr>
                    <th width="30%">Dari Tanggal</th>
                    <th width="1%">:</th>
                    <td><?= $tgl_dari; ?></td>
                </tr>
                <tr>
                    <th>Sampai Tanggal</th>
                    <th>:</th>
                    <td><?= $tgl_sampai; ?></td>
                </tr>
                <tr>
                    <th>Jenis</th>
                    <th>:</th>
                    <td><?= $jenis; ?></td>
                </tr>
            </table>

            <br>

            <table border="1" class="print">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($aset as $am) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $am['nama_barang']; ?></td>
                            <td><?= $am['tanggal_keluar']; ?></td>
                            <td><?= $am['jumlah']; ?></td>
                            <td><?= $am['keterangan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>