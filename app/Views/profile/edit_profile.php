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
                        <form action="/profile" method="POST" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" id="id" value="<?= $user['id']; ?>">
                            <input type="hidden" name="oldImage" id="oldImage" value="<?= $user['image']; ?>">
                            <div class="form-group row">
                                <label for="role" class="col-sm-2 col-form-label">Level User</label>
                                <div class="col-sm-10">
                                    <?php if (session()->get('role') == 1) : ?>
                                        <input type="text" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" name="role" id="role" value="Super Admin" readonly>
                                    <?php elseif (session()->get('role') == 2) : ?>
                                        <input type="text" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" name="role" id="role" value="Admin" readonly>
                                    <?php elseif (session()->get('role') == 3) : ?>
                                        <input type="text" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : ''; ?>" name="role" id="role" value="User" readonly>
                                    <?php endif; ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('role'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" name="username" id="username" value="<?= $user['username']; ?>" readonly>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('username'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= ($validation->hasError('name')) ? 'is-invalid' : ''; ?>" name="name" id="name" value="<?= $user['name']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" id="email" value="<?= $user['email']; ?>">
                                </div>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telephone" class="col-sm-2 col-form-label">No. HP</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control <?= ($validation->hasError('telephone')) ? 'is-invalid' : ''; ?>" name="telephone" id="telephone" value="<?= $user['telephone']; ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('telephone'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (session()->get('role') == 2 || session()->get('role') == 3) : ?>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <select name="gender" id="gender" class="form-control <?= ($validation->hasError('gender')) ? 'is-invalid' : ''; ?>">
                                            <option value="">===Pilih Salah Satu===</option>
                                            <option value="Laki-laki" <?= ($user['gender'] == 'Laki-laki') ? 'selected' : old('gender'); ?>>Laki-laki</option>
                                            <option value="Perempuan" <?= ($user['gender'] == 'Perempuan') ? 'selected' : old('gender'); ?>>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email'); ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control <?= ($validation->hasError('address')) ? 'is-invalid' : ''; ?>" name="address" id="address" rows="3"><?= (old('address')) ? old('address') : $user['address']; ?></textarea>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('address'); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class=" form-group row">
                                <label for="image" class="col-sm-2 col-form-label">Foto</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="/img/profile/<?= $user['image']; ?>" class="img-thumbnail img-preview">
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image" onchange="previewImg()">
                                                <label class="custom-file-label" for="image"><?= $user['image']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    function previewImg() {
        const image = document.querySelector('#image')
        const imageLabel = document.querySelector('.custom-file-label')
        const imgPreview = document.querySelector('.img-preview')

        imageLabel.textContent = image.files[0].name

        const fileimage = new FileReader()
        fileimage.readAsDataURL(image.files[0])

        fileimage.onload = function(e) {
            imgPreview.src = e.target.result
        }
    }
</script>
<?= $this->endSection(); ?>