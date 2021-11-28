<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="/user/<?= $user['id']; ?>" method="POST">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="nik">NIK Pegawai</label>
                                    <input type="number" class="form-control <?= ($validation->hasError('nik')) ? 'is-invalid' : ''; ?>" name="nik" id="nik" value="<?= (old('nik')) ? old('nik') : $user['nik']; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nik'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Nama Lengkap</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" id="name" value="<?= (old('name')) ? old('name') : $user['name']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" value="<?= (old('username')) ? old('username') : $user['username']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('username'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= (old('email')) ? old('email') : $user['email']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email'); ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role">Level User</label>
                                    <select name="role" id="role" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>">
                                        <option value="">===Pilih Role===</option>
                                        <option value="2" <?= ($user['role'] == 2) ? 'selected' : old('role'); ?>>Admin</option>
                                        <option value="3" <?= ($user['role'] == 3) ? 'selected' : old('role'); ?>>User</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('role'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="telephone">No. HP</label>
                                    <input type="number" class="form-control <?= ($validation->hasError('telephone')) ? 'is-invalid' : ''; ?>" name="telephone" id="telephone" value="<?= (old('telephone')) ? old('telephone') : $user['telephone']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('telephone'); ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select name="gender" id="gender" class="form-control <?= ($validation->hasError('gender')) ? 'is-invalid' : ''; ?>">
                                        <option value="">===Pilih Salah Satu===</option>
                                        <option value="Laki-laki" <?= ($user['gender'] == 'Laki-laki') ? 'selected' : old('gender'); ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($user['gender'] == 'Perempuan') ? 'selected' : old('gender'); ?>>Perempuan</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('gender'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" name="address" id="address" rows="3"><?= (old('address')) ? old('address') : $user['address']; ?></textarea>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('address'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Update Data</button>
                                    <a href="<?= base_url('user'); ?>" class="btn btn-secondary">Kembali</a>
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