<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/aset">Aset</a></li>
        <li class="breadcrumb-item active">Detail Aset</li>
    </ol>
    <?php ($rupiah) ?>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    Detail Data Aset
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td>Kode Aset</td>
                                <td>:</td>
                                <td><?= $aset['kode_aset']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Aset</td>
                                <td>:</td>
                                <td><?= $aset['nama_barang']; ?></td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>:</td>
                                <td><?= $aset['nama_kategori']; ?></td>
                            </tr>
                            <tr>
                                <td>Merek</td>
                                <td>:</td>
                                <td><?= $aset['merek']; ?></td>
                            </tr>
                            <tr>
                                <td>Kondisi</td>
                                <td>:</td>
                                <td><?= $aset['kondisi']; ?></td>
                            </tr>
                            <tr>
                                <td>Tahun Perolehan</td>
                                <td>:</td>
                                <td><?= $aset['tahun_perolehan']; ?></td>
                            </tr>
                            <tr>
                                <td>Lokasi Aset</td>
                                <td>:</td>
                                <td><?= $aset['nama_gedung']; ?> - <?= $aset['nama_ruangan']; ?></td>
                            </tr>
                            <tr>
                                <td>Satuan</td>
                                <td>:</td>
                                <td><?= $aset['satuan']; ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>:</td>
                                <td><?= $aset['jumlah']; ?></td>
                            </tr>
                            <tr>
                                <td>Nilai Aset</td>
                                <td>:</td>
                                <td>Rp. <?= number_format(intval($aset['nilai_aset']), 0, ".", "."); ?></td>
                            </tr>
                            <tr>
                                <td>Total Aset</td>
                                <td>:</td>
                                <td>Rp. <?= number_format(intval($aset['total_aset']), 0, ".", "."); ?></td>
                            </tr>
                            <tr>
                                <td>Sumber</td>
                                <td>:</td>
                                <td><?= $aset['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>Penginput</td>
                                <td>:</td>
                                <td><?= $aset['user_penginput']; ?></td>
                            </tr>
                            <tr>
                                <td>Foto</td>
                                <td>:</td>
                                <td><img src="/img/aset/<?= $aset['foto']; ?>" alt="<?= $aset['nama_barang']; ?>" width="500px"></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?= base_url('aset'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    QR Code
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="/img/aset/qr/<?= $aset['qr_code']; ?>" alt="<?= $aset['kode_aset']; ?>" width="300px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>