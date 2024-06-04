<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-md-5 col-lg-3">
    <div class="card">
        <div class="card-body p-4 text-center">
            <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url(<?= avatar(null, $userdata) ?>)"></span>
            <h3 class="m-0 mb-1">
                <?= $userdata->name ?>
            </h3>
            <div class="text-muted"><?= permission($userdata->role) ?></div>
            <?php if ($userdata->role == '1') : ?>
                <div class="mt-3">
                    <span class="badge bg-purple-lt">Admin</span>
                </div>
            <?php endif ?>
        </div>
        <div class="d-flex">
            <a href="<?= base_url('logout') ?>" class="card-btn">
                <?= tabler_icon('logout') ?>
                Keluar
            </a>
        </div>
    </div>
</div>

<div class="col-md-7 col-lg-9">
    <div class="row row-cards">
        <div class="col-12">
            <?= form_open_multipart($settings->app_prefix . '/profile/save', ['class' => 'card']) ?>
            <div class="card-header">
                <h3 class="card-title">Profil & Akun</h3>
            </div>

            <div class="card-body">
                <div class="form-group mb-3">
                    <label class="form-label">Nama pengguna</label>
                    <input type="text" class="form-control" value="<?= $userdata->login ?>" readonly="">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Nama lengkap</label>
                    <input type="text" class="form-control" name="name" value="<?= $userdata->name ?>">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Alamat surel</label>
                    <input type="email" class="form-control" name="email" value="<?= $userdata->email ?>">
                </div>
                <div class="mb-0">
                    <div class="form-label">Foto profil</div>
                    <input type="file" class="form-control" name="avatar" />
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>

        <div class="col-12">
            <?= form_open_multipart($settings->app_prefix . '/profile/password', ['class' => 'card']) ?>
            <div class="card-header">
                <h3 class="card-title">Kata Sandi</h3>
            </div>

            <div class="card-body">
                <div class="form-group mb-3">
                    <label class="form-label">Kata sandi lama</label>
                    <input type="password" class="form-control" name="oldpass">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Kata sandi baru</label>
                    <input type="password" class="form-control" name="newpass">
                </div>
                <div class="form-group mb-0">
                    <label class="form-label">Ulangi kata sandi baru</label>
                    <input type="password" class="form-control" name="repass">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
