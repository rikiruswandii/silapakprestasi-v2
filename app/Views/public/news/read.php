<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-10 col-xl-8 mx-auto">
                <div class="post-header">
                    <div class="post-category text-line">
                        <a href="<?= base_url('category/' . $category->slug) ?>" class="hover" rel="category"><?= $category->name ?></a>
                    </div>
                    <h1 class="display-1 mb-4"><?= $detail->title ?></h1>
                    <ul class="post-meta mb-5">
                        <li class="post-date">
                            <i class="uil uil-calendar-alt"></i>
                            <span><?= indonesian_date($detail->updated_at ?: $detail->created_at, false, true) ?></span>
                        </li>
                        <li class="post-author">
                            <i class="uil uil-user"></i>
                            <span>Oleh Admin</span>
                        </li>
                        <li class="post-comments">
                            <a href="#comments" class="scroll">
                                <i class="uil uil-comment"></i>
                                <span style="display: inline-block;" data-cusdis-count-page-id="<?= $detail->slug ?>">0</span> <span>Komentar</span>
                            </a>
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

<section class="wrapper bg-light angled upper-end">
    <div class="container pb-14 pb-md-16">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="blog single mt-n17">
                    <div class="card">
                        <?php if ($detail->thumbnail) : ?>
                            <figure class="card-img-top">
                                <img src="<?= safe_media('thumbnails', $detail->thumbnail) ?>" alt="<?= $detail->title ?>" />
                            </figure>
                        <?php endif ?>

                        <div class="card-body">
                            <div class="classic-view">
                                <article class="post">
                                    <div class="post-content mb-5">
                                        <?= $detail->content ?>
                                    </div>

                                    <div class="post-footer d-md-flex flex-md-row justify-content-md-between align-items-center mt-8">
                                        <div>
                                            <?php if ($previous || $next) : ?>
                                                <div class="align-self-center text-center text-md-start navigation">
                                                    <?php if ($previous) : ?>
                                                        <a href="<?= $previous->slug ?>" class="btn btn-sm btn-soft-ash rounded-pill btn-icon btn-icon-start mb-0 me-1">
                                                            <i class="uil uil-arrow-left"></i>
                                                            Sebelumnya
                                                        </a>
                                                    <?php endif ?>

                                                    <?php if ($next) : ?>
                                                        <a href="<?= $next->slug ?>" class="btn btn-sm btn-soft-ash rounded-pill btn-icon btn-icon-end mb-0">
                                                            Selanjutnya
                                                            <i class="uil uil-arrow-right"></i>
                                                        </a>
                                                    <?php endif ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                        <div class="mb-0 mb-md-2 mt-5 text-center">
                                            <?= $this->include('public/_includes/share') ?>
                                        </div>
                                    </div>
                                </article>
                            </div>

                            <hr />

                            <div id="comments">
                                <h3 class="mb-6">Komentar</h3>
                                <?= $this->include('public/_includes/cusdis') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('lowerbody') ?>
<script defer data-host="<?= $settings->cusdis_host ?>" data-app-id="<?= $settings->cusdis_id ?>" src="<?= $settings->cusdis_host ?>/js/cusdis-count.umd.js"></script>
<?= $this->endSection() ?>
