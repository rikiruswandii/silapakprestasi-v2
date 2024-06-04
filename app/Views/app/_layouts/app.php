<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= set_panel_title($page, $settings->app_name) ?>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/dropify@0.2.2/dist/css/dropify.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler-flags.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler-payments.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/tabler-vendors.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('app/css/custom.css') ?>">
    <?= $this->renderSection("stylesheet") ?>
</head>

<body class="antialiased">
    <div class="wrapper">
        <div class="sticky-top">
            <?= $this->include('app/_includes/header') ?>

            <?= $this->include('app/_includes/navbar') ?>
        </div>

        <?= $this->include('app/_includes/failed-alert') ?>
        <?= $this->include('app/_includes/success-alert') ?>

        <div class="page-wrapper">
            <?= $this->include('app/_includes/page-header') ?>

            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-cards">
                        <?= $this->renderSection('body') ?>
                    </div>

                    <?= $this->renderSection('pagination') ?>
                </div>
            </div>

            <?= $this->include('app/_includes/footer') ?>
        </div>
    </div>

    <?= $this->renderSection('modal') ?>

    <script src="<?= base_url('app/js/tabler.min.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
    <script src="<?= base_url('app/libs/ckeditor5/build/ckeditor.js') ?>"></script>
    <script src="//cdn.jsdelivr.net/npm/dropify@0.2.2/dist/js/dropify.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/litepicker@2.0.11/dist/litepicker.js"></script>
    <script src="//cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>
    <?= $this->renderSection('javascript') ?>
    <script src="<?= base_url('app/js/custom.js') ?>"></script>
</body>

</html>