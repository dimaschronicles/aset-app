<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <ol class="breadcrumb mb-4" style="background-color: white;">
        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/user">User</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Tambah Data User
                </div>
                <div class="card-body">
                    <form action="/user" method="POST">
                        <?= csrf_field(); ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" value="<?= old('username'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('username'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="role">Level User</label>
                                <select name="role" id="role" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>">
                                    <option value="">===Pilih Role===</option>
                                    <option value="2" <?= (old('role') == 2) ? 'selected' : ''; ?>>Admin</option>
                                    <option value="3" <?= (old('role') == 3) ? 'selected' : ''; ?>>User</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('role'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" id="name" value="<?= old('name'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('name'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control <?= ($validation->hasError('jabatan')) ? 'is-invalid' : ''; ?>" name="jabatan" id="jabatan" value="<?= old('jabatan'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jabatan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= old('email'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telephone">No. HP</label>
                                <input type="number" class="form-control <?= ($validation->hasError('telephone')) ? 'is-invalid' : ''; ?>" name="telephone" id="telephone" value="<?= old('telephone'); ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('telephone'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="address">Alamat</label>
                                <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" name="address" id="address" rows="3"><?= old('address'); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('address'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password'); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_conf">Konfirmasi Password</label>
                                <input type="password" class="form-control <?= ($validation->hasError('password_conf')) ? 'is-invalid' : ''; ?>" name="password_conf" id="password_conf">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('password_conf'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="show_pass" id="show_pass" onclick="showPass()">
                                <label class="form-check-label" for="show_pass">
                                    Show Password
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Tambah Data</button>
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

<script type="text/javascript">
    function showPass() {
        var pass = document.getElementById("password");
        var pass_conf = document.getElementById("password_conf");
        if (pass.type && pass_conf.type === "password") {
            pass.type = "text";
            pass_conf.type = "text";
        } else {
            pass.type = "password";
            pass_conf.type = "password";
        }
    }
</script>
<?= $this->endSection(); ?>