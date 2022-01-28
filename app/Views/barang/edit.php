<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/barang">Barang</a></li>
        <li class="breadcrumb-item active">Ubah Barang</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Form Ubah Data Barang
                </div>
                <div class="card-body">
                    <form action="/barang/<?= $barang['id_barang']; ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id_barang" id="id_barang" value="<?= $barang['id_barang']; ?>">
                        <div class="form-group row">
                            <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('nama_barang')) ? 'is-invalid' : ''; ?>" name="nama_barang" id="nama_barang" value="<?= (old('nama_barang')) ? old('nama_barang') : $barang['nama_barang']; ?>" placeholder="Masukan Nama Barang...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_barang'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="merek" class="col-sm-3 col-form-label">Merek</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('merek')) ? 'is-invalid' : ''; ?>" name="merek" id="merek" value="<?= (old('merek')) ? old('merek') : $barang['merek']; ?>" placeholder="Masukan Merek...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('merek'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tahun_perolehan" class="col-sm-3 col-form-label">Tahun Perolehan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('tahun_perolehan')) ? 'is-invalid' : ''; ?>" name="tahun_perolehan" id="tahun_perolehan" value="<?= (old('tahun_perolehan')) ? old('tahun_perolehan') : $barang['tahun_perolehan']; ?>" placeholder="Ex: 20XX">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tahun_perolehan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                                <a href="<?= base_url('barang'); ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>