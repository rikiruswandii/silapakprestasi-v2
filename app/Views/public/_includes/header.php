<header class="wrapper bg-soft-primary">
    <nav class="navbar center-nav transparent navbar-expand-lg navbar-light">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100">
                <a href="<?= base_url() ?>">
<<<<<<< HEAD
                    <img height="80px" src="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?>" srcset="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?> 2x" alt="<?= $settings->app_title ?>" /> <span class="gradient-text-1"><b>Purwakarta</b></span>
=======
                    <img src="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?>" srcset="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?> 2x" alt="<?= $settings->app_title ?>" /> <span class="gradient-text-1"><b>Purwakarta</b></span>
>>>>>>> 0a3910ec512764671cb3618f0c15c70ad864f088
                </a>
            </div>

            <div class="navbar-collapse offcanvas-nav">
                <div class="offcanvas-header d-lg-none d-xl-none">
                    <a href="<?= base_url() ?>">
                        <img src="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?>" srcset="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?> 2x" alt="<?= $settings->app_title ?>" />
                    </a>
                    <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
                </div>

                <?= $this->include('public/_includes/navbar') ?>
            </div>

            <div class="navbar-other w-100 d-flex ms-auto">
                <?= $this->include('public/_includes/navbar-other') ?>
            </div>
        </div>
    </nav>
</header>