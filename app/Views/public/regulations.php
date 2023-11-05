<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<style>
    table {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-10 col-xl-8 mx-auto">
                <div class="post-header">
                    <h1 class="display-1 mb-4"><?= $type ?></h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Regulasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $field ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light angled upper-start">
    <div class="container pb-14 pb-md-16">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="blog single mt-n17">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="classic-view">
                                <article class="post">
                                    <div class="post-content">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%; white-space: nowrap;">#</th>
                                                    <th>Nama</th>
                                                    <th style="width: 1%; white-space: nowrap;">Unduh</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($regulations) > 0) : ?>
                                                    <?php foreach ($regulations as $no => $regulation) : ?>
                                                        <tr>
                                                            <td><?= $no + 1 ?></td>
                                                            <td><?= $regulation->name ?></td>
                                                            <td>
                                                                <a href="<?= safe_media('contents', $regulation->file) ?>" class="text-primary">
                                                                    <?= tabler_icon('download') ?>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="3">
                                                            Belum ada regulasi yang diterbitkan.
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
