<html>

<head>
    <title>QR Code Aset</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px;
        }

        td {
            text-align: center;
        }

        image {
            padding: 4px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <br>
    <table border="1">
        <tr>
            <?php $kolom = 3;
            $i = 0;
            foreach ($aset as $a) : ?>
                <?php if ($i >= $kolom) : ?>
                    <?= "<tr></tr>";
                    $i++; ?>
                <?php endif; ?>
                <td><img src="/img/aset/qr/<?= $a['qr_code']; ?>" alt="<?= $a['kode_aset']; ?>" width="100px"><br><?= $a['kode_aset']; ?></td>
            <?php endforeach; ?>
        </tr>
    </table>
</body>

</html>