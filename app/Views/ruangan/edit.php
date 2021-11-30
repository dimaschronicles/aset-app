<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/ruangan">Ruangan</a></li>
        <li class="breadcrumb-item active">Ubah Ruangan</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Form Ubah Data Ruangan
                </div>
                <div class="card-body">
                    <form action="/ruangan/<?= $ruangan['id_ruangan']; ?>" method="POST">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="kode" class="col-sm-3 col-form-label">Kode Ruangan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('kode')) ? 'is-invalid' : ''; ?>" name="kode" id="kode" value="<?= (old('kode')) ? old('kode') : $ruangan['kode_ruangan']; ?>" placeholder="Ex: RG001">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-3 col-form-label">Nama Ruangan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="nama" value="<?= (old('nama')) ? old('nama') : $ruangan['nama_ruangan']; ?>" placeholder="Nama Ruangan...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gedung" class="col-sm-3 col-form-label">Lokasi Gedung</label>
                            <div class="col-sm-9">
                                <select name="gedung" id="gedung" class="form-control <?= ($validation->hasError('gedung')) ? 'is-invalid' : ''; ?>">
                                    <option value="">===Pilih Gedung===</option>
                                    <?php foreach ($gedung as $g) : ?>
                                        <option value="<?= $g['id_gedung']; ?>" <?= ($ruangan['id_gedung'] == $g['id_gedung']) ? 'selected' : old('gedung'); ?>><?= $g['nama_gedung']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('gedung'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                                <a href="<?= base_url('ruangan'); ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>