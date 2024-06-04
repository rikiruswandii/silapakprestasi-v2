<header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="<?= base_url($settings->app_prefix . '/overview') ?>">
                <img src="<?= base_url('assets/img/logo-investasi-purwakarta (x2).png') ?>" width="158" height="50" alt="<?= $settings->app_title ?>" class="navbar-brand-image">
            </a>
        </h1>

        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(<?= avatar(null, $userdata) ?>)"></span>

                    <div class="d-none d-xl-block ps-2">
                        <div><?= $userdata->name ?></div>
                        <div class="mt-1 small text-muted">
                            <?= permission($userdata->role) ?>
                        </div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="<?= base_url($settings->app_prefix . '/profile') ?>" class="dropdown-item">Profil & Akun</a>
                    <a href="<?= base_url() ?>" target="_blank" class="dropdown-item">Lihat Situs</a>
                    <a href="<?= base_url('logout') ?>" class="dropdown-item">Keluar</a>
                </div>
            </div>
        </div>
    </div>
</header>
