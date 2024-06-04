<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-md-6 col-lg-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title">Selamat Datang!</div>
            <div class="row">
                <dt class="col-5">
                    <span class="text-primary"><?= tabler_icon('user') ?></span>
                    <span class="ms-1">Nama</span>
                </dt>
                <dd class="col-7">
                    : <?= $userdata->name ?>
                </dd>
                <dt class="col-5">
                    <span class="text-primary"><?= tabler_icon('lock-open') ?></span>
                    <span class="ms-1">Masuk</span>
                </dt>
                <dd class="col-7">
                    : <?= $userdata->login ?>
                </dd>
                <dt class="col-5">
                    <span class="text-primary"><?= tabler_icon('mail') ?></span>
                    <span class="ms-1">Surel</span>
                </dt>
                <dd class="col-7">
                    : <?= $userdata->email ?>
                </dd>
                <dt class="col-5">
                    <span class="text-primary"><?= tabler_icon('history') ?></span>
                    <span class="ms-1">Terdaftar</span>
                </dt>
                <dd class="col-7">
                    : <?= indonesian_date($userdata->created_at) ?>
                </dd>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-4">
    <div class="card">
        <div class="card-body">
            <div class="card-title">Informasi dasar</div>
            <dl class="row">
                <dt class="col-5">Kota</dt>
                <dd class="col-7">
                    : <?= $city ?>
                </dd>
                <dt class="col-5">Provinsi</dt>
                <dd class="col-7">
                    : <?= $state ?>
                </dd>
                <dt class="col-5">Negara</dt>
                <dd class="col-7">
                    : <span class="flag flag-country-<?= $country_code ?>"></span>
                    <span class="ms-1"><?= $country ?></span>
                </dd>
                <dt class="col-5">Alamat IP</dt>
                <dd class="col-7">
                    : <?= $ip ?>
                </dd>
                <dt class="col-5">OS</dt>
                <dd class="col-7">
                    : <?= $agent->getPlatform() ?>
                </dd>
                <dt class="col-5">Peramban</dt>
                <dd class="col-7">
                    : <?= $agent->getBrowser() ?>
                </dd>
            </dl>
        </div>
    </div>
</div>

<div class="col-md-6 col-lg-4">
    <div class="card">
        <div class="card-body text-center">
            <div class="mb-3">
                <span class="avatar avatar-xl avatar-rounded" style="background-image: url(<?= avatar(null, $userdata) ?>)"></span>
            </div>
            <div class="card-title mb-1"><?= $userdata->name ?></div>
            <div class="text-muted">Administrator</div>
        </div>
        <a href="<?= base_url($settings->app_prefix . "/profile") ?>" class="card-btn">Ubah Profil</a>
    </div>
</div>
<?= $this->endSection() ?>
