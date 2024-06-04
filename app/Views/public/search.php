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
<?php if (count($products) <= 0) : ?>
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-12 pt-md-14 pb-md-16 text-center">
            <div class="row">
                <div class="col-md-7 col-lg-6 col-xl-5 mx-auto">
                    <h1 class="display-1 mb-3">"<?= $keyword ?>"</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper bg-light">
        <div class="container py-10 py-md-14 text-center">
            <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center justify-content-center">
                <div class="col-lg-5">
                    <figure>
                        <img class="w-auto" src="<?= base_url('assets/img/concept/concept18.png') ?>" srcset="<?= base_url('assets/img/concept/concept18@2x.png') ?> 2x" alt="" />
                    </figure>
                </div>
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start">
                    <h1 class="mb-5 mx-md-n5 mx-lg-0">Sesuatu yang Anda cari tidak dapat ditemukan.</h1>
                    <p class="lead fs-lg mb-7">Mungkin beberapa artikel sudah dihapus atau bahkan tidak pernah dipublikasikan.</p>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>
    <section class="wrapper bg-soft-primary">
        <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
            <div class="row">
                <div class="col-md-7 col-lg-6 col-xl-5 mx-auto">
                    <h1 class="display-1 mb-3">"<?= $keyword ?>"</h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hasil Pencarian</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper bg-light">
        <div class="container pb-14 pb-md-16">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="blog grid grid-view mt-n17">
                        <div class="row isotope gx-md-8 gy-8 mb-8">
                            <?php foreach ($products as $item) : ?>
                                <article class="item post col-md-4">
                                    <div class="card">
                                        <figure class="card-img-top overlay overlay1 hover-scale">
                                            <a href="<?= base_url($item->type . '/' . $item->slug) ?>">
                                                <img src="<?= safe_media('thumbnails', $item->thumbnail) ?>" alt="<?= $item->title ?>" />
                                            </a>
                                            <figcaption>
                                                <h5 class="from-top mb-0">Selengkapnya</h5>
                                            </figcaption>
                                        </figure>
                                        <div class="card-body">
                                            <div class="post-header">
                                                <div class="post-category text-line">
                                                    <a href="<?= base_url(($item->type == 'opportunity' ? 'opportunities' : $item->type . 's')) ?>" class="hover" rel="category"><?= $item->type == 'opportunity' ? 'Potensi & Peluang' : ($item->type == 'investment' ? 'Promosi Investasi' : ($item->type == 'profile' ? 'Profil Instansi' : 'Promosi Inovasi')) ?></a>
                                                </div>
                                                <h2 class="post-title h3 mt-1 mb-3">
                                                    <a class="link-dark" href="<?= base_url($item->type . '/' . $item->slug) ?>">
                                                        <?= $item->title ?>
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="post-content">
                                                <p><?= cuttext(strip_tags($item->content)) ?></p>
                                            </div>
                                        </div>

                                        <div class="card-footer">
                                            <ul class="post-meta d-flex mb-0">
                                                <li class="post-date">
                                                    <i class="uil uil-calendar-alt"></i>
                                                    <span><?= indonesian_date($item->updated_at ?: $item->created_at, false, true) ?></span>
                                                </li>
                                                <li class="post-comments ms-auto">
                                                    <i class="uil uil-eye"></i>
                                                    <?= $item->views ?>
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
