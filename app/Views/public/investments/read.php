<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<style>
    .text-justify p:last-child {
        margin-bottom: 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-22 text-center">
        <div class="row">
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <div class="post-header">
                    <div class="post-category text-line">
                        <a href="<?= base_url('investments/' . $detail->slugsector) ?>" class="hover" rel="category"><?= $detail->sector ?></a>
                    </div>
                    <h1 class="display-1 mb-14 mb-md-3"><?= $detail->title ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light wrapper-border">
    <div class="container pb-14 pb-md-16">
        <div class="row">
            <div class="col-12">
                <article class="mt-n21">
                    <figure class="rounded mb-8 mb-md-12">
                        <img src="<?= safe_media('thumbnails', $detail->thumbnail) ?>" alt="<?= $detail->title ?>" />
                    </figure>
                    <div class="row">
                        <div class="col-lg-10 offset-lg-1">
                            <h2 class="display-6 mb-4">Deskripsi</h2>
                            <div class="row gx-0">
                                <div class="col-md-9 text-justify">
                                    <?= $detail->content ?>
                                </div>

                                <div class="col-md-2 ms-auto">
                                    <ul class="list-unstyled">
                                        <li>
                                            <h5 class="mb-1">Sektor</h5>
                                            <p>
                                                <a href="<?= base_url('investments/' . $detail->slugsector) ?>" class="hover" rel="category"><?= $detail->sector ?></a>
                                            </p>
                                        </li>
                                        <li>
                                            <h5 class="mb-1">Dipublikasikan</h5>
                                            <p><?= indonesian_date($detail->updated_at ?: $detail->created_at, false, true) ?></p>
                                        </li>
                                        <li>
                                            <h5 class="mb-1">Oleh</h5>
                                            <p>Admin</p>
                                        </li>
                                        <li>
                                            <h5 class="mb-1">Dilihat</h5>
                                            <p><?= $detail->views ?>x</p>
                                        </li>
                                    </ul>
                                    <a href="<?= base_url('investments') ?>" class="more hover">Lihat Lainnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light">
    <div class="container py-10">
        <div class="row gx-md-6 gy-3 gy-md-0">
            <div class="col-md-8 align-self-center text-center text-md-start navigation">
                <?php if ($previous) : ?>
                    <a href="<?= $previous->slug ?>" class="btn btn-soft-ash rounded-pill btn-icon btn-icon-start mb-0 me-1">
                        <i class="uil uil-arrow-left"></i>
                        Sebelumnya
                    </a>
                <?php endif ?>
                <?php if ($next) : ?>
                    <a href="<?= $next->slug ?>" class="btn btn-soft-ash rounded-pill btn-icon btn-icon-end mb-0">
                        Selanjutnya
                        <i class="uil uil-arrow-right"></i>
                    </a>
                <?php endif ?>
            </div>

            <aside class="col-12 sidebar text-center text-md-end">
                <?= $this->include('public/_includes/share') ?>
            </aside>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
