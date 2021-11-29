<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Aset
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : 12
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Admin
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : 3
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        User
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : 8
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        Terhapus
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        Jumlah : 6
                    </div>
                </div>
            </div>
        </div>

</div>
<?= $this->endSection(); ?>