<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <?= set_title($page, $settings->app_name, $settings->app_title) ?>

    <link rel="stylesheet" href="<?= base_url('app/css/tabler.min.css') ?>">
</head>

<body class="antialiased d-flex flex-column">
    <div class="page page-center">
        <div class="container-tight py-4">
            <div class="empty">
                <div class="empty-img">
                    <img src="<?= base_url('app/img/maintenance.svg') ?>" style="width: 100%; height: auto;" alt="Sedang Dalam Pemeliharaan">
                </div>
                <p class="empty-title"><?= $page ?></p>
                <p class="empty-subtitle text-muted">
                    Maaf atas ketidaknyamanan ini, tetapi kami sedang melakukan beberapa pemeliharaan saat ini. Kami akan segera kembali online!
                </p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('app/js/tabler.min.js') ?>"></script>
</body>

</html>
