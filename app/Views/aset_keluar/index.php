<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active">Aset Keluar</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col">

            <div class="d-inline">
                <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdropAddAset">
                        <i class="fas fa-plus me-1"></i> Tambah Aset Keluar
                    </button>
                <?php endif; ?>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdropAddAset" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Aset Keluar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form action="/asetkeluar" method="POST">
                            <div class="modal-body">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="user_penginput" value="<?= $user; ?>">
                                <div class="form-group">
                                    <label for="id_aset">Nama Aset</label>
                                    <select class="form-control" name="id_aset" id="id_aset" class="form-control <?= ($validation->hasError('id_aset')) ? 'is-invalid' : ''; ?>" required>
                                        <option value="">=== Pilih ===</option>
                                        <?php foreach ($aset as $a) : ?>
                                            <option value="<?= $a['id_barang']; ?>" <?= (old('id_aset') == $a['id_barang']) ? 'selected' : ''; ?>><?= $a['nama_barang'] ?> - <?= $a['nama_ruangan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('id_aset'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>" name="jumlah" id="jumlah" value="<?= old('jumlah'); ?>" placeholder="Masukan jumlah aset keluar..." required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Keluar</label>
                                    <input type="date" class="form-control <?= ($validation->hasError('tanggal_keluar')) ? 'is-invalid' : ''; ?>" name="tanggal_keluar" id="tanggal_keluar" value="<?= old('tanggal_keluar'); ?>" required>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('tanggal_keluar'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" name="keterangan" id="keterangan" rows="3" required></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('keterangan'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Alert Message -->
            <div class="mt-3">
                <?= session()->getFlashdata('message'); ?>
            </div>

            <div class="card mt-3 mb-3">
                <div class="card-header">
                    Daftar Aset Keluar
                </div>
                <!-- Table -->
                <div class="card-body shadow-sm">
                    <div class="responsive">
                        <table class="table table-bordered text-center" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Penginput</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($asetKeluar as $ak) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $ak['nama_barang']; ?></td>
                                        <td><?= $ak['tanggal_keluar']; ?></td>
                                        <td><?= $ak['jumlah']; ?></td>
                                        <td><?= $ak['keterangan']; ?></td>
                                        <td><?= $ak['user_penginput']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?= $ak['id_aset_keluar']; ?>">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal<?= $ak['id_aset_keluar'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <form action="/asetkeluar/<?= $ak['id_aset_keluar']; ?>" method="post" class="d-inline">
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