<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-8">

                <div class="mt-1">
                    <?= session()->getFlashdata('message'); ?>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <?= form_open_multipart('/aset/import') ?>
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="file_excel" class="col-sm-3 col-form-label">Excel / CSV</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" name="file_excel" id="file_excel" accept=".xls, .xlsx, .csv" required>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Import</button>
                                <a href="/aset" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
</div>
<?= $this->endSection(); ?>