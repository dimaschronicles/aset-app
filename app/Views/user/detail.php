<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/user">User</a></li>
        <li class="breadcrumb-item active">Detail User</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col">
            <div class="card-body shadow-lg">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/img/profile/<?= $user['foto']; ?>" alt="<?= $user['nama']; ?>" class="card-img">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><b>Username</b></td>
                                        <td><?= $user['username']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Nama</b></td>
                                        <td><?= $user['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td><?= $user['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No. HP</b></td>
                                        <td><?= $user['no_telp']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat</b></td>
                                        <td><?= $user['alamat']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Level User</b></td>
                                        <?php if ($user['role'] == 2) : ?>
                                            <td>Admin</td>
                                        <?php elseif ($user['role'] == 3) : ?>
                                            <td>User</td>
                                        <?php endif; ?>
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