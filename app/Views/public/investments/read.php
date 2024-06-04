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
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-10 col-xl-8 mx-auto">
                <div class="post-header">
                    <div class="post-category text-line">
                        <a href="<?= base_url('investments/' . $detail->slugsector) ?>" class="hover" rel="category"><?= $detail->sector ?></a>
                    </div>
                    <h1 class="display-1 mb-4"><?= $page ?></h1>
                    <ul class="post-meta mb-4">
                        <li class="post-date">
                            <i class="uil uil-calendar-alt"></i>
                            <span><?= indonesian_date($detail->updated_at ?: $detail->created_at, false, true) ?></span>
                        </li>
                        <li class="post-author">
                            <i class="uil uil-user"></i>
                            <span>Oleh Admin</span>
                        </li>
                        <li class="post-comments">
                            <i class="uil uil-eye"></i>
                            <?= $detail->views ?> <span>Pembaca</span>
                        </li>
                    </ul>
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
                        <div class="card-body">
                            <div class="classic-view">
                                <article class="post">
                                    <?php if ($detail->pdf == null) : ?>
                                        <div class="post-content mb-5">
                                            <?= $detail->content ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="post-content">
                                            <embed id="pdfnibos" src="<?= safe_media('contents', $detail->pdf) ?>" type="application/pdf" class="w-100" style="width: 100%; height: 100vh;">
                                        </div>
                                    <?php endif ?>

                                    <div class="post-footer d-md-flex flex-md-row justify-content-md-between align-items-center mt-8">
                                        <div></div>
                                        <div class="mb-0 mb-md-2">

                                        </div>
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
