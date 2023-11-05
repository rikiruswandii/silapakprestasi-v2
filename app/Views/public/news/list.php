<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<style>
    .card>figure img {
        height: 322px !important;
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-7 col-lg-6 col-xl-5 mx-auto">
                <h1 class="display-1 mb-3"><?= $page ?></h1>
                <nav class="d-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                        <?php if (isset($category)) : ?>
                            <li class="breadcrumb-item" aria-current="page"><a href="<?= base_url('news') ?>">Berita</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0)">Kategori</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= ucwords(strtolower($category)) ?></li>
                        <?php else : ?>
                            <li class="breadcrumb-item active" aria-current="page">Berita</li>
                        <?php endif ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<?php if (count($news) <= 0) : ?>
    <section class="wrapper bg-light">
        <div class="container py-10 py-md-14 text-center mt-n12">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <figure>
                        <img class="w-auto" src="<?= base_url('assets/img/concept/concept18.png') ?>" srcset="<?= base_url('assets/img/concept/concept18@2x.png') ?> 2x" alt="" />
                    </figure>
                </div>
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start">
                    <h1 class="mb-5 mx-md-n5 mx-lg-0"><?= ucfirst(strtolower($page)) ?> yang Anda cari tidak dapat ditemukan.</h1>
                    <p class="lead fs-lg mb-7">Mungkin beberapa artikel sudah dihapus atau bahkan tidak pernah dipublikasikan.</p>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>
    <section class="wrapper bg-light">
        <div class="container pb-14 pb-md-16">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="blog grid grid-view mt-n17">
                        <div class="row isotope gx-md-8 gy-8 mb-8">
                            <?php foreach ($news as $article) : ?>
                                <article class="item post col-md-4">
                                    <div class="card">
                                        <figure class="card-img-top overlay overlay1 hover-scale">
                                            <a href="<?= base_url('news/' . $article->slug) ?>">
                                                <img src="<?= safe_media('thumbnails', $article->thumbnail) ?>" alt="<?= $article->title ?>" />
                                            </a>
                                            <figcaption>
                                                <h5 class="from-top mb-0">Selengkapnya</h5>
                                            </figcaption>
                                        </figure>
                                        <div class="card-body">
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="<?= base_url('category/' . $article->slugcat) ?>" class="hover" rel="category"><?= $article->category ?></a>
                                                </div>
                                                <h2 class="post-title h3 mt-1 mb-3">
                                                    <a class="link-dark" href="<?= base_url('news/' . $article->slug) ?>">
                                                        <?= $article->title ?>
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="post-content">
                                                <p><?= cuttext(strip_tags($article->content)) ?></p>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <ul class="post-meta d-flex mb-0">
                                                <li class="post-date">
                                                    <i class="uil uil-calendar-alt"></i>
                                                    <span><?= indonesian_date($article->updated_at ?: $article->created_at, false, true) ?></span>
                                                </li>
                                                <li class="post-comments">
                                                    <i class="uil uil-comment"></i>
                                                    <span style="display: inline-block;" data-cusdis-count-page-id="<?= $article->slug ?>">0</span>
                                                </li>
                                                <li class="post-comments ms-auto">
                                                    <i class="uil uil-eye"></i>
                                                    <?= $article->views ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach ?>
                        </div>
                    </div>

                    <?php if ($pager->getPageCount() > 1) : ?>
                        <nav class="d-flex" aria-label="pagination">
                            <?= $pager->links('default', 'sandbox_post') ?>
                        </nav>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>
<?= $this->endSection() ?>

<?= $this->section('lowerbody') ?>
<script defer src="<?= $settings->cusdis_host ?>/js/cusdis-count.umd.js"></script>
<?= $this->endSection() ?>
