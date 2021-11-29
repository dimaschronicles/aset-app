<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <ol class="breadcrumb mb-4" style="background-color: white;">
            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
            <li class="breadcrumb-item active">Gedung</li>
        </ol>
        <hr>
        <div class="row">
            <div class="col">

                <div class="d-inline">
                    <a href="/gedung/add" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Gedung</a>
                </div>

                <!-- Alert Message -->
                <div class="mt-3">
                    <?= session()->getFlashdata('message'); ?>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Daftar Gedung
                    </div>
                    <!-- Table -->
                    <div class="card-body shadow-lg">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Gedung</th>
                                        <th>Nama Gedung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($gedung as $g) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $g['kode_gedung']; ?></td>
                                            <td><?= $g['nama_gedung']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $g['id_gedung']; ?>">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                                <a href="/gedung/edit/<?= $g['kode_gedung']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $g['id_gedung'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah data ini akan dihapus?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/gedung/<?= $g['id_gedung']; ?>" method="post" class="d-inline">
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