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
                        <form action="/profile/reset" method="POST">
                            <?= csrf_field(); ?>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= old('email'); ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_conf" class="col-sm-3 col-form-label">Konfirmasi Password Baru</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control <?= ($validation->hasError('password_conf')) ? 'is-invalid' : ''; ?>" name="password_conf" id="password_conf">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password_conf'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="show_pass" id="show_pass" onclick="showPass()">
                                        <label class="form-check-label" for="show_pass">
                                            Show Password
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">
    function showPass() {
        var pass = document.getElementById("current_password");
        var new_pass = document.getElementById("new_password");
        var pass_conf = document.getElementById("password_conf");

        if (pass.type && new_pass.type && pass_conf.type === "password") {
            pass.type = "text";
            new_pass.type = "text";
            pass_conf.type = "text";
        } else {
            pass.type = "password";
            new_pass.type = "password";
            pass_conf.type = "password";
        }
    }
</script>
<?= $this->endSection(); ?>