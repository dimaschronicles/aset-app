<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <hr>
    <div class="row">
        <div class="col">
            <div class="card-body shadow-lg">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/<?= $user['image']; ?>" alt="<?= $user['name']; ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><b>NIK</b></td>
                                        <td><?= $user['nik']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Username</b></td>
                                        <td><?= $user['username']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama</b></td>
                                        <td><?= $user['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td><?= $user['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. HP</b></td>
                                        <td><?= $user['telephone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat</b></td>
                                        <td><?= $user['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Jenis Kelamin</b></td>
                                        <td><?= $user['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Level User</b></td>
                                        <?php if ($user['role'] == 2) : ?>
                                            <td>Admin</td>
                                        <?php elseif ($user['role'] == 3) : ?>
                                            <td>User</td>
                                        <?php endif; ?>
                                    </tr>
                                    <tr>
                                        <td><b>Tanggal Input</b></td>
                                        <td><?= $user['created_at']; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <a href="/user" class="btn btn-dark">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>