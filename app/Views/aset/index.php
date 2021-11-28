<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <hr>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Barang</li>
    </ol>
    <div class="row">
        <div class="col">

            <div class="d-inline">
                <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                    <a href="/aset/add" class="btn btn-primary"><i class="fas fa-laptop me-1"></i> Tambah Barang</a>
                    <a href="/aset/trash" class="btn btn-outline-danger"><i class="fas fa-trash-alt me-1"></i> Sampah</a>
                    <a href="/aset/excel" class="btn btn-outline-success"><i class="fas fa-upload me-1"></i> Import Excel</a>
                    <a href="/aset/templateexcel" class="ml-2"><i class="fas fa-download me-1"></i> Unduh Template Excel</a>
                <?php endif; ?>
            </div>

            <!-- Alert Message -->
            <div class="mt-3">
                <?= session()->getFlashdata('message'); ?>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    Daftar Barang
                </div>
                <!-- Table -->
                <div class="card-body shadow-lg">
                    <div class="responsive">
                        <table class="table table-bordered text-center" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Aset</th>
                                    <th>Kondisi</th>
                                    <th>Tanggal Pengadaan</th>
                                    <th>Penginput</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($barang as $b) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $b['kode_barang']; ?></td>
                                        <td><?= $b['kondisi_aset']; ?></td>
                                        <td><?= $b['tanggal_pengadaan']; ?></td>
                                        <td><?= $b['user_penginput']; ?></td>
                                        <td>
                                            <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $b['id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <a href="/aset/edit/<?= $b['kode_barang']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <?php endif; ?>

                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal<?= $b['nomor']; ?>">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $b['kode_barang']; ?>">
                                                <i class="fas fa-qrcode"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="exampleModal<?= $b['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah data ini akan dihapus?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="/aset/<?= $b['id']; ?>" method="post" class="d-inline">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger">Ya</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Detail -->
                                    <div class="modal fade" id="exampleModal<?= $b['nomor']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail Aset</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p><b>Nomor</b></p>
                                                            <p><b>Sub Nomor</b></p>
                                                            <p><b>Satuan</b></p>
                                                            <p><b>Kode Barang</b></p>
                                                            <p><b>Tercatat</b></p>
                                                            <p><b>No Aset</b></p>
                                                            <p><b>Kode Lokasi</b></p>
                                                            <p><b>Kode Perkap</b></p>
                                                            <p><b>Kondisi Aset</b></p>
                                                            <p><b>Uraian Aset</b></p>
                                                            <p><b>Uraian Perkap</b></p>
                                                            <p><b>Kode Ruang</b></p>
                                                            <p><b>Uraian Ruang</b></p>
                                                            <p><b>Catatan</b></p>
                                                            <p><b>Kondisi</b></p>
                                                            <p><b>Nominal</b></p>
                                                            <p><b>Tanggal Pengadaan</b></p>
                                                            <p><b>Sumber Pengadaan</b></p>
                                                            <p><b>Foto</b></p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                            <p><b>:</b></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><?= $b['nomor']; ?></p>
                                                            <p><?= $b['sub_nomor']; ?></p>
                                                            <p><?= $b['satuan']; ?></p>
                                                            <p><?= $b['kode_barang']; ?></p>
                                                            <p><?= $b['tercatat']; ?></p>
                                                            <p><?= $b['no_aset']; ?></p>
                                                            <p><?= $b['kode_lokasi']; ?></p>
                                                            <p><?= $b['kode_perkap']; ?></p>
                                                            <p><?= $b['kondisi_aset']; ?></p>
                                                            <p><?= $b['uraian_aset']; ?></p>
                                                            <p><?= $b['uraian_perkap']; ?></p>
                                                            <p><?= $b['kode_ruang']; ?></p>
                                                            <p><?= $b['uraian_ruang']; ?></p>
                                                            <p><?= $b['catatan']; ?></p>
                                                            <p><?= $b['kondisi']; ?></p>
                                                            <p><?= $b['nominal_aset']; ?></p>
                                                            <p><?= $b['tanggal_pengadaan']; ?></p>
                                                            <p><?= $b['sumber_pengadaan']; ?></p>
                                                            <img src="/img/aset/<?= $b['foto']; ?>" alt="<?= $b['kode_barang']; ?>" width="300px" class="img-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal QR -->
                                    <div class="modal fade" id="exampleModal<?= $b['kode_barang']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="/img/aset/qr/<?= $b['qr_code']; ?>" alt="" class="rounded mx-auto d-block">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>