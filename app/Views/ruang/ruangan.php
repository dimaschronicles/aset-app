<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/super">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ruangan</li>
        </ol>
        <div class="row">
            <div class="col">

                <div class="d-inline">
                    <a href="/ruang/add" class="btn btn-primary"><i class="fas fa-door-open me-1"></i> Tambah ruangan</a>
                </div>

                <!-- Alert Message -->
                <div class="mt-3">
                    <?= session()->getFlashdata('message'); ?>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        Daftar Ruangan
                    </div>
                    <!-- Table -->
                    <div class="card-body shadow-lg">
                        <div class="responsive">
                            <table class="table table-bordered text-center" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Ruangan</th>
                                        <th>Lokasi Ruangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($ruang as $r) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $r['kode']; ?></td>
                                            <td><?= $r['nama']; ?></td>
                                            <td>
                                                <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $r['id']; ?>">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                <?php endif; ?>
                                                <a href="/ruang/edit/<?= $r['kode']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                            </td>
                                        </tr>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal<?= $r['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Peringatan</h5>
                                                        <button type="button" class="close" aria-label="Close">
                                                            <span aria-hidden="true" data-dismiss="modal">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah data ini akan dihapus?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/ruang/<?= $r['id']; ?>" method="POST">
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