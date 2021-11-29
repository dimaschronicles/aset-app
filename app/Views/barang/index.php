<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item active">Barang</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col">

            <div class="d-inline">
                <?php if (session()->get('role') == 1 || session()->get('role') == 2) : ?>
                    <a href="/aset/add" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Barang</a>
                <?php endif; ?>
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
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Merek</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>TEKNOLOGI INFORMASI</td>
                                    <td>ASUS VivoBook</td>
                                    <td>ASUS</td>
                                    <td>2019</td>
                                    <td>
                                        <a href="" class="btn btn-warning">Edit</a>
                                        <a href="" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>