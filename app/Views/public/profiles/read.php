<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-10 col-xl-8 mx-auto">
                <div class="post-header">
                    <div class="post-category text-line">
                        <a href="<?= base_url('profiles') ?>" class="hover" rel="category">Profil Instansi</a>
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
                                        <div class="post-content">
                                            <div style="overflow: auto;">
                                                <?= $detail->content ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="post-content">
                                            <embed src="<?= safe_media('contents', $detail->pdf) ?>" type="application/pdf" style="width: 100%; height: 100vh;" />
                                        </div>
                                    <?php endif ?>

                                    <div class="post-footer d-md-flex flex-md-row justify-content-md-between align-items-center mt-8">
                                        <div></div>
                                        <div class="mb-0 mb-md-2">
                                            <?= $this->include('public/_includes/share') ?>
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
<?= $this->endSection() ?>
