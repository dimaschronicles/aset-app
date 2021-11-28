<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="/gedung/<?= $gedung['id']; ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group row">
                                <label for="kode" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" name="kode" id="kode" value="<?= (old('kode')) ? old('kode') : $gedung['kode']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= (old('nama')) ? old('nama') : $gedung['nama']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control <?= ($validation->hasError('lokasi')) ? 'is-invalid' : ''; ?>" name="lokasi" id="lokasi" value="<?= (old('lokasi')) ? old('lokasi') : $gedung['lokasi']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('lokasi'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                    <a href="<?= base_url('gedung'); ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Content -->

<?= $this->endSection(); ?>