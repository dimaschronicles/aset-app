<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid px-4">
    <h2 class="mt-4 mb-4"><?= $title; ?></h2>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <form action="/aset/<?= $aset['id_aset']; ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="user_penginput" id="user_penginput" value="<?= $user; ?>">
                        <input type="hidden" name="old_image" id="old_image" value="<?= $aset['foto']; ?>">
                        <div class="form-group row">
                            <label for="kode_aset" class="col-sm-3 col-form-label">Kode Aset</label>
                            <div class="col-sm-9">
                                <input type="kode_aset" class="form-control <?= ($validation->hasError('kode_aset')) ? 'is-invalid' : ''; ?>" id="kode_aset" name="kode_aset" value="<?= $aset['kode_aset']; ?>" readonly>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kode_aset'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nama_aset" class="col-sm-3 col-form-label">Nama Aset</label>
                            <div class="col-sm-9">
                                <select class="form-control <?= ($validation->hasError('nama_aset')) ? 'is-invalid' : ''; ?>" name="nama_aset" id="nama_aset">
                                    <option value="">=== Pilih ===</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option value="<?= $b['id_barang']; ?>" <?= ($aset['id_barang'] == $b['id_barang']) ? 'selected' : old('nama_aset'); ?>><?= $b['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('nama_aset'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                                <select name="kategori" id="kategori" class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : ''; ?>">
                                    <option value="">=== Pilih Kategori ===</option>
                                    <?php foreach ($kategori as $k) : ?>
                                        <option value="<?= $k['id_kategori']; ?>" <?= ($aset['id_kategori'] == $k['id_kategori']) ? 'selected' : old('id_kategori'); ?>><?= $k['kode_kategori']; ?> - <?= $k['nama_kategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kategori'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $aset['jumlah']; ?>" placeholder="Masukan jumlah...">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('jumlah'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                            <div class="col-sm-9">
                                <select class="form-control <?= ($validation->hasError('satuan')) ? 'is-invalid' : ''; ?>" name="satuan" id="satuan">
                                    <option value="">=== Pilih ===</option>
                                    <option value="Unit" <?= ($aset['satuan'] == 'Unit') ? 'selected' : old('satuan'); ?>>Unit</option>
                                    <option value="Buah" <?= ($aset['satuan'] == 'Buah') ? 'selected' : old('satuan'); ?>>Buah</option>
                                    <option value="Set" <?= ($aset['satuan'] == 'Set') ? 'selected' : old('satuan'); ?>>Set</option>
                                    <option value="Paket" <?= ($aset['satuan'] == 'Paket') ? 'selected' : old('satuan'); ?>>Paket</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('satuan'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kondisi" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <select class="form-control <?= ($validation->hasError('kondisi')) ? 'is-invalid' : ''; ?>" name="kondisi" id="kondisi">
                                    <option value="">=== Pilih ===</option>
                                    <option value="Baik" <?= ($aset['kondisi'] == 'Baik') ? 'selected' : old('kondisi'); ?>>Baik</option>
                                    <option value="Kurang" <?= ($aset['kondisi'] == 'Kurang') ? 'selected' : old('kondisi'); ?>>Kurang</option>
                                    <option value="Rusak" <?= ($aset['kondisi'] == 'Rusak') ? 'selected' : old('kondisi'); ?>>Rusak</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('kondisi'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lokasi_aset" class="col-sm-3 col-form-label">Lokasi Aset</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control <?= ($validation->hasError('gedung')) ? 'is-invalid' : ''; ?>" name="gedung" id="gedung">
                                            <option value="">=== Pilih Gedung ===</option>
                                            <?php foreach ($gedung as $g) : ?>
                                                <option value="<?= $g['id_gedung']; ?>" <?= ($gedung_selected == $g['id_gedung'] || $aset['id_gedung'] == $g['id_gedung']) ? 'selected' : old('gedung'); ?>><?= $g['nama_gedung']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('gedung'); ?>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <select class="form-control <?= ($validation->hasError('ruangan')) ? 'is-invalid' : ''; ?>" name="ruangan" id="ruangan">
                                            <option value="">=== Pilih Ruangan ===</option>
                                            <?php foreach ($ruangan as $r) : ?>
                                                <option value="<?= $r['id_ruangan']; ?>" <?= ($ruangan_selected == $r['id_gedung'] || $aset['id_ruangan'] == $r['id_ruangan']) ? 'selected' : old('ruangan'); ?> class="<?= $r['id_gedung']; ?>"><?= $r['nama_ruangan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('ruangan'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nilai_aset" class="col-sm-3 col-form-label">Nilai Aset</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp</span>
                                    </div>
                                    <input type="text" class="form-control  <?= ($validation->hasError('nilai_aset')) ? 'is-invalid' : ''; ?>" name="nilai_aset" id="nilai_aset" value="<?= (old('nilai_aset')) ? old('nilai_aset') : number_format($aset['nilai_aset'], 0, ".", "."); ?>" name="nilai_aset" id="nilai_aset" aria-label="Nominal" aria-describedby="basic-addon1" placeholder="000">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nilai_aset'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sumber" class="col-sm-3 col-form-label">Sumber / Supplier</label>
                            <div class="col-sm-9">
                                <select class="form-control <?= ($validation->hasError('sumber')) ? 'is-invalid' : ''; ?>" name="sumber" id="sumber">
                                    <option value="">=== Pilih ===</option>
                                    <?php foreach ($supplier as $s) : ?>
                                        <option value="<?= $s['id_supplier']; ?>" <?= ($aset['nama'] == $s['nama']) ? 'selected' : old('sumber'); ?>><?= $s['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('sumber'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                                <textarea type="text" class="form-control <?= ($validation->hasError('keterangan')) ? 'is-invalid' : ''; ?>" name="keterangan" id="keterangan" rows="3"><?= (old('keterangan')) ? old('keterangan') : $aset['keterangan']; ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('keterangan'); ?>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <label for="tanggal_masuk" class="col-sm-3 col-form-label">Tanggal Masuk</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control <?= ($validation->hasError('tanggal_masuk')) ? 'is-invalid' : ''; ?>" id="tanggal_masuk" name="tanggal_masuk" value="<?= (old('tanggal_masuk')) ? old('tanggal_masuk') : $aset['tanggal_masuk']; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('tanggal_masuk'); ?>
                                </div>
                            </div>
                        </div> -->

                        <div class=" form-group row">
                            <label for="image" class="col-sm-3 col-form-label">Foto</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <img src="/img/aset/<?= $aset['foto']; ?>" class="img-thumbnail img-preview">
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image" onchange="previewImg()">
                                            <label class="custom-file-label" for="image"><?= $aset['foto']; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                                <a href="<?= base_url('aset'); ?>" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-chained/1.0.1/jquery.chained.min.js"></script>
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

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    var tanpa_rupiah = document.getElementById('nilai_aset');
    tanpa_rupiah.addEventListener('keyup', function(e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    $("#ruangan").chained("#gedung");
</script>

<?= $this->endSection(); ?>