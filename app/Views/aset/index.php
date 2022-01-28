<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active">Aset</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col">

            <div class="d-inline">
                <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                    <a href="/aset/add" class="btn btn-primary"><i class="fas fa-laptop me-1"></i> Tambah Aset</a>
                    <a href="/report/asetpdf" class="btn btn-outline-danger" target="_blank"><i class="fas fa-file-pdf me-1"></i> Download PDF</a>
                    <a href="/report/asetexcel" class="btn btn-outline-success" target="_blank"><i class="fas fa-file-excel me-1"></i> Download Excel</a>
                    <a href="/report/asetqr" class="btn btn-outline-info" target="_blank"><i class="fas fa-qrcode me-1"></i> Download QR-Code</a>
                <?php endif; ?>
            </div>

            <form action="/aset" method="GET" class="form-inline mt-3">
                <label class="my-1 mr-2" for="filter_kondisi">Filter by Kondisi</label>
                <select class="custom-select my-1 mr-sm-2" name="filter_kondisi" id="filter_kondisi">
                    <option value="">=== Pilih Kondisi ===</option>
                    <option value="Baik" <?= (@$_GET['kondisi'] == 'Baik') ? 'selected' : ''; ?>>Baik</option>
                    <option value="Kurang" <?= (@$_GET['kondisi'] == 'Kurang') ? 'selected' : ''; ?>>Kurang</option>
                    <option value="Rusak" <?= (@$_GET['kondisi'] == 'Rusak') ? 'selected' : ''; ?>>Rusak</option>
                </select>
                <button type="submit" class="btn btn-primary my-1">Filter Data</button>
            </form>

            <!-- <div class="row">
                <div class="col col-lg-auto">
                    <form action="/aset" method="GET" class="form-inline mt-3">
                        <label class="my-1 mr-2" for="filter_kondisi">Filter by Kondisi</label>
                        <select class="custom-select my-1 mr-sm-2" name="filter_kondisi" id="filter_kondisi">
                            <option value="">=== Pilih Kondisi ===</option>
                            <option value="Baik" <?= (@$_GET['kondisi'] == 'Baik') ? 'selected' : ''; ?>>Baik</option>
                            <option value="Kurang" <?= (@$_GET['kondisi'] == 'Kurang') ? 'selected' : ''; ?>>Kurang</option>
                            <option value="Rusak" <?= (@$_GET['kondisi'] == 'Rusak') ? 'selected' : ''; ?>>Rusak</option>
                        </select>
                        <button type="submit" class="btn btn-primary my-1">Filter Data</button>
                    </form>
                </div>
                <div class="col">
                    <form action="/aset" method="GET" class="form-inline mt-3">
                        <label class="my-1 mr-2" for="filter_kondisi">Filter by Ruangan</label>
                        <select class="custom-select my-1 mr-sm-2" name="filter_kondisi" id="filter_kondisi">
                            <option value="">=== Pilih Ruangan ===</option>
                            <option value="Baik" <?= (@$_GET['kondisi'] == 'Baik') ? 'selected' : ''; ?>>Baik</option>
                        </select>
                        <button type="submit" class="btn btn-primary my-1">Filter Data</button>
                    </form>
                </div>
            </div> -->

            <!-- Alert Message -->
            <div class="mt-3">
                <?= session()->getFlashdata('message'); ?>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-header">
                    Daftar Aset
                </div>
                <!-- Table -->
                <?php if ($filter_kondisi == null) : ?>
                    <div class="card-body shadow-sm">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aset</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah</th>
                                        <th>Nilai Aset</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($aset as $a) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $a['kode_aset']; ?></td>
                                            <td><?= $a['nama_barang']; ?></td>
                                            <td><?= $a['satuan']; ?></td>
                                            <td><?= $a['kondisi']; ?></td>
                                            <td><?= $a['jumlah']; ?></td>
                                            <td>Rp. <?= number_format(intval($a['nilai_aset']), 0, ".", "."); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $a['id_aset']; ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                <a href="/aset/edit/<?= $a['kode_aset']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="/aset/detail/<?= $a['kode_aset']; ?>" class="btn btn-info" target="_blank"><i class="fas fa-info"></i> Detail</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $a['id_aset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <!-- <h5 class="modal-title" id="exampleModalLabel">Peringatan! Data Ini Akan Dihapus?</h5> -->
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Dengan menghapus, semua data aset keluar dan aset masuk yang berhubungan dengan aset ini akan ikut dihapus. -->
                                                        Apakah data ini akan dihapus?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/aset/delete/<?= $a['id_aset']; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <!-- <input type="hidden" name="_method" value="DELETE"> -->
                                                            <button type="submit" class="btn btn-danger">Ya</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php elseif ($filter_kondisi == 'Baik') : ?>
                    <div class="card-body shadow-sm">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aset</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah</th>
                                        <th>Nilai Aset</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($aset as $a) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $a['kode_aset']; ?></td>
                                            <td><?= $a['nama_barang']; ?></td>
                                            <td><?= $a['satuan']; ?></td>
                                            <td><?= $a['kondisi']; ?></td>
                                            <td><?= $a['jumlah']; ?></td>
                                            <td>Rp. <?= number_format(intval($a['nilai_aset']), 0, ".", "."); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $a['id_aset']; ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                <a href="/aset/edit/<?= $a['kode_aset']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="/aset/detail/<?= $a['kode_aset']; ?>" class="btn btn-info" target="_blank"><i class="fas fa-info"></i> Detail</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $a['id_aset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan! Data Ini Akan Dihapus?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Dengan menghapus, semua data aset keluar dan aset masuk yang berhubungan dengan aset ini akan ikut dihapus.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/aset/<?= $a['id_aset']; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger">Ya</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php elseif ($filter_kondisi == 'Kurang') : ?>
                    <div class="card-body shadow-sm">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aset</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah</th>
                                        <th>Nilai Aset</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($aset as $a) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $a['kode_aset']; ?></td>
                                            <td><?= $a['nama_barang']; ?></td>
                                            <td><?= $a['satuan']; ?></td>
                                            <td><?= $a['kondisi']; ?></td>
                                            <td><?= $a['jumlah']; ?></td>
                                            <td>Rp. <?= number_format(intval($a['nilai_aset']), 0, ".", "."); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $a['id_aset']; ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                <a href="/aset/edit/<?= $a['kode_aset']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="/aset/detail/<?= $a['kode_aset']; ?>" class="btn btn-info" target="_blank"><i class="fas fa-info"></i> Detail</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $a['id_aset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan! Data Ini Akan Dihapus?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Dengan menghapus, semua data aset keluar dan aset masuk yang berhubungan dengan aset ini akan ikut dihapus.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/aset/<?= $a['id_aset']; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger">Ya</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php elseif ($filter_kondisi == 'Rusak') : ?>
                    <div class="card-body shadow-sm">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aset</th>
                                        <th>Nama</th>
                                        <th>Satuan</th>
                                        <th>Kondisi</th>
                                        <th>Jumlah</th>
                                        <th>Nilai Aset</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($aset as $a) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $a['kode_aset']; ?></td>
                                            <td><?= $a['nama_barang']; ?></td>
                                            <td><?= $a['satuan']; ?></td>
                                            <td><?= $a['kondisi']; ?></td>
                                            <td><?= $a['jumlah']; ?></td>
                                            <td>Rp. <?= number_format(intval($a['nilai_aset']), 0, ".", "."); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $a['id_aset']; ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                <a href="/aset/edit/<?= $a['kode_aset']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                                <a href="/aset/detail/<?= $a['kode_aset']; ?>" class="btn btn-info" target="_blank"><i class="fas fa-info"></i> Detail</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $a['id_aset'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan! Data Ini Akan Dihapus?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Dengan menghapus, semua data aset keluar dan aset masuk yang berhubungan dengan aset ini akan ikut dihapus.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/aset/<?= $a['id_aset']; ?>" method="post" class="d-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button type="submit" class="btn btn-danger">Ya</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>