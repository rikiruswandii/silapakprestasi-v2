<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <?= set_title($page, $settings->app_name, $settings->app_title) ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="<?= $settings->app_keywords ?>" />
    <meta name="description" content="<?= $settings->app_description ?>" />
    <meta name="subject" content="Situs Pemerintahan" />
    <meta name="copyright" content="<?= $settings->app_holder ?>" />
    <meta name="language" content="Indonesia" />
    <meta name="robots" content="index, follow" />
    <meta name="Classification" content="Government" />

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $settings->app_title ?>">
    <meta property="og:description" content="<?= $settings->app_description ?>">
    <meta property="og:image" content="<?= base_url('assets/img/concept/concept2.png') ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?= $settings->app_title ?>">
    <meta property="twitter:description" content="<?= $settings->app_description ?>">
    <meta property="twitter:image" content="<?= base_url('assets/img/concept/concept2.png') ?>">

    <meta name="category" content="Government" />
    <meta name="coverage" content="Worldwide" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="revisit-after" content="7 days" />

    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Copyright" content="<?= $settings->app_holder ?>" />
    <meta http-equiv="imagetoolbar" content="no" />

    <meta name="revisit-after" content="7" />
    <meta name="webcrawlers" content="all" />
    <meta name="rating" content="general" />
    <meta name="spiders" content="all" />

    <meta itemprop="name" content="<?= $settings->app_title ?>" />
    <meta itemprop="description" content="<?= $settings->app_description ?>" />
    <meta itemprop="image" content="<?= base_url('assets/img/concept/concept2.png') ?>" />

    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('icons/apple-touch-icon.png?v=ZRH76pf0tE') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('icons/favicon-32x32.png?v=ZRH76pf0tE') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('icons/favicon-16x16.png?v=ZRH76pf0tE') ?>">
    <link rel="manifest" href="<?= base_url('icons/site.webmanifest?v=ZRH76pf0tE') ?>">
    <link rel="mask-icon" href="<?= base_url('icons/safari-pinned-tab.svg?v=ZRH76pf0tE') ?>" color="#5bbad5">
    <link rel="shortcut icon" href="<?= base_url('icons/favicon.ico?v=ZRH76pf0tE') ?>">
    <meta name="apple-mobile-web-app-title" content="<?= $settings->app_name ?>">
    <meta name="application-name" content="<?= $settings->app_name ?>">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-config" content="<?= base_url('icons/browserconfig.xml?v=ZRH76pf0tE') ?>">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="<?= base_url('assets/css/plugins.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    <?= $this->renderSection('headtag') ?>
</head>

<body>
    <div class="content-wrapper">
        <?php if (isset($this->whiteHeader)) : ?>
            <?= $this->include('public/_includes/header-white') ?>
        <?php else : ?>
            <?= $this->include('public/_includes/header') ?>
        <?php endif ?>

        <?= $this->renderSection('content') ?>
    </div>

    <?= isset($this->withoutFooter) ? '' : $this->include('public/_includes/footer') ?>
    <?= $this->include('public/_includes/gotop') ?>

    <script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="<?= base_url('assets/js/plugins.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@latest"></script>
    <script src="//cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="<?= base_url('assets/js/theme.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom.js') ?>"></script>
    
    
    <?= $this->renderSection('lowerbody') ?>
</body>

</html>