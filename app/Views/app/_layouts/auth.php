<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= set_title($page, $settings->app_name, $settings->app_title) ?>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler-vendors.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/custom.css') ?>">
</head>

<body class="antialiased d-flex flex-column">
    <?= $this->renderSection('content') ?>

    <script src="<?= base_url('app/js/tabler.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="<?= base_url('app/js/custom.js') ?>"></script>
</body>

</html>
