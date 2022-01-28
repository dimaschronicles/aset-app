<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/supplier">Supplier</a></li>
        <li class="breadcrumb-item active">Tambah Supplier</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Form Tambah Data Supplier
                </div>
                <div class="card-body">
                    <form action="/supplier" method="POST">
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="kode" class="col-sm-3 col-form-label">Kode Supplier</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" name="kode" id="kode" value="<?= old('kode'); ?>" placeholder="Ex: SP001">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= old('nama'); ?>" placeholder="Nama Supplier...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                                <textarea class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" rows="3"><?= old('alamat'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('alamat'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_telp" class="col-sm-3 col-form-label">No Telephone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('no_telp')) ? 'is-invalid' : ''; ?>" name="no_telp" id="no_telp" value="<?= old('no_telp'); ?>" placeholder="Ex: 0214...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('no_telp'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
                                <a href="<?= base_url('supplier'); ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>