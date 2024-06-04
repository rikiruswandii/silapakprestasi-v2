<?= $this->extend('app/_layouts/auth') ?>

<?= $this->section('content') ?>
<div class="page page-center">
    <div class="container-tight py-4">
        <div class="text-center mb-4">
            <a href="<?= base_url() ?>">
                <img src="<?= base_url('assets/img/logo-investasi-purwakarta.png') ?>" height="158px" alt="<?= $settings->app_title ?>">
            </a>
        </div>

        <?= form_open('auth/check', ['class' => 'card card-md', 'autocomplete' => 'off']) ?>
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Masuk ke Akun</h2>

            <?= $this->include('app/_includes/failed-alert') ?>

            <div class="mb-3">
                <label for="login" class="form-label">Nama Pengguna</label>
                <input type="text" name="login" id="login" class="form-control" placeholder="Masukkan nama pengguna" value="<?= get_cookie('login') ?: old('login') ?>" autofocus="">
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group input-group-flat">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="off">

                    <span class="input-group-text">
                        <a href="javascript:void(0)" class="link-secondary" id="show-password" title="Lihat kata sandi" data-bs-toggle="tooltip">
                            <?= tabler_icon('eye') ?>
                        </a>
                    </span>
                </div>
            </div>

            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" name="remember" value="1" class="form-check-input" />
                    <span class="form-check-label">Ingat saya</span>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $this->endSection() ?>
