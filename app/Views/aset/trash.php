<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <hr>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/aset/">Aset</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sampah Barang</li>
    </ol>
    <div class="row">
        <div class="col">

            <div class="d-inline">
                <a href="/aset" class="btn btn-secondary">Kembali</a>
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
                                    <th>Kode Barang</th>
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
                                        <td><?= $b['kondisi']; ?></td>
                                        <td><?= $b['tanggal_pengadaan']; ?></td>
                                        <td><?= $b['user_penginput']; ?></td>
                                        <td>
                                            <form action="/aset/restore/<?= $b['id']; ?>" method="post" class="d-inline">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-info">
                                                    <i class="fas fa-trash-restore"></i> Restore
                                                </button>
                                            </form>
                                            <button type=" button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $b['kode_barang']; ?>">
                                                <i class="fas fa-trash-alt"></i> Hapus Permanen
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Delete Permanen -->
                                    <div class="modal fade" id="exampleModal<?= $b['kode_barang']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah data ini akan dihapus secara permanen?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="/aset/destroy/<?= $b['kode_barang']; ?>" method="post" class="d-inline">
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
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>