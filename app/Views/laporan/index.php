<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active">Laporan Data Aset</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col">


            <div class="card">
                <div class="card-header">
                    Filter Laporan
                </div>

                <div class="card-body shadow-sm">
                    <form action="/report" method="GET">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="tanggal_dari">Dari Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari" value="<?= @$_GET['tanggal_dari'] ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_sampai">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai" value="<?= @$_GET['tanggal_sampai'] ?>" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="jenis">Laporan</label>
                                <select id="jenis" name="jenis" class="form-control" required>
                                    <option value="">=== Pilih ===</option>
                                    <option value="Aset Masuk" <?= (@$_GET['jenis'] == 'Aset Masuk') ? 'selected' : ''; ?>>Aset Masuk</option>
                                    <option value="Aset Keluar" <?= (@$_GET['jenis'] == 'Aset Keluar') ? 'selected' : ''; ?>>Aset Keluar</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <button type="submit" name="filter" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            if (empty($transaksi)) : ?>
                <?php if ($jenis == "Aset Masuk") : ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            Laporan
                        </div>

                        <?php
                        $tgl_dari = @$_GET['tanggal_dari'];
                        $tgl_sampai = @$_GET['tanggal_sampai'];
                        $jenis = @$_GET['jenis'];
                        ?>

                        <div class="card-body shadow-sm">
                            <div class="row">
                                <div class="col-lg-6">
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
                                </div>
                            </div>

                            <div class="mb-3">
                                <a href="/report/printpdf?tanggal_dari=<?= $tgl_dari; ?>&tanggal_sampai=<?= $tgl_sampai; ?>&jenis=<?= $jenis; ?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Download Laporan</a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th width="1%">No</th>
                                            <th>Nama Barang</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($aset as $a) : ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $a['nama_barang']; ?></td>
                                                <td><?= $a['tanggal_masuk']; ?></td>
                                                <td><?= $a['jumlah']; ?></td>
                                                <td><?= $a['keterangan']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php elseif ($jenis == "Aset Keluar") : ?>
                            <div class="card mt-3">
                                <div class="card-header">
                                    Laporan
                                </div>

                                <?php
                                $tgl_dari = @$_GET['tanggal_dari'];
                                $tgl_sampai = @$_GET['tanggal_sampai'];
                                $jenis = @$_GET['jenis'];
                                ?>

                                <div class="card-body shadow-sm">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <table class="table">
                                                <tr>
                                                    <th width="30%">Dari Tanggal</th>
                                                    <th width="1%">:</th>
                                                    <td><?= @$_GET['tanggal_dari'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Sampai Tanggal</th>
                                                    <th>:</th>
                                                    <td><?= @$_GET['tanggal_sampai'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis</th>
                                                    <th>:</th>
                                                    <td><?= @$_GET['jenis'] ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <a href="/report/printpdf?tanggal_dari=<?= $tgl_dari; ?>&tanggal_sampai=<?= $tgl_sampai; ?>&jenis=<?= $jenis; ?>" target="_blank" class="btn btn-primary"><i class="fas fa-download"></i> Download Laporan</a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="datatablesSimple">
                                            <thead>
                                                <tr>
                                                    <th width="1%">No</th>
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
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
        <?= $this->endSection(); ?>