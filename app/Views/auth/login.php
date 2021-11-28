<?= $this->extend('layout/template_auth'); ?>

<?= $this->section('content'); ?>
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-3"><?= $title; ?></h3>
                            </div>
                            <div class="card-body mb-2">

                                <?= session()->getFlashdata('message'); ?>

                                <form method="POST" action="/auth/login">
                                    <?= csrf_field(); ?>
                                    <div class="form-floating mb-3 mt-2">
                                        <input class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" type="text" placeholder="name@example.com" autofocus value="<?= old('username'); ?>" />
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('username'); ?>
                                        </div>
                                        <label for="username">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" type="password" placeholder="Password" />
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('password'); ?>
                                        </div>
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" onclick="myFunction()" />
                                        <label class="form-check-label" for="inputRememberPassword">Show Password</label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary" type="submit"><i class="fas fa-sign-in-alt"></i> Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small">
                                    <div class="text-muted">Copyright &copy; <?= date('Y'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?= $this->endSection(); ?>