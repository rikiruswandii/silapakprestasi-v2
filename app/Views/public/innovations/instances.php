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
    <div class="container pt-10 pb-12 pt-md-14 pb-md-16 text-center">
        <div class="row">
            <div class="col-md-7 col-lg-6 col-xl-5 mx-auto">
                <h1 class="display-1 mb-3"><?= $page ?></h1>
                <nav class="d-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Pelayanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Promosi Inovasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light wrapper-border">
    <div class="container inner py-8">
        <div class="row gx-lg-8 gx-xl-12 gy-4 gy-lg-0">
            <div class="col-lg-8 align-self-center">
                <div class="blog-filter filter">
                    <p>Pelayanan:</p>
                    <ul>
                        <li><a href="<?= base_url('profiles') ?>">Profil Instansi</a></li>
                        <li><a class="active" href="<?= base_url('innovations') ?>">Promosi Inovasi</a></li>
                    </ul>
                </div>
            </div>
            <aside class="col-lg-4 sidebar">
                <form class="search-form" method="GET">
                    <div class="form-label-group mb-0">
                        <input name="s" id="search-form" type="text" class="form-control" placeholder="Cari <?= strtolower($page) ?> ..." value="<?= $keyword ?>">
                        <label for="search-form">Cari <?= strtolower($page) ?> ...</label>
                    </div>
                </form>
            </aside>
        </div>
    </div>
</section>

<?php if (count($instances) <= 0) : ?>
    <section class="wrapper bg-light">
        <div class="container py-10 py-md-14 text-center">
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
        <div class="container py-14 py-md-16">
            <div class="row grid-view gy-6 gy-lg-8 mb-12" data-masonry='{ "itemSelector": ".col-md-6" }'>
                <?php foreach ($instances as $item) : ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="position-relative">
                            <div class="shape rounded bg-soft-blue rellax d-md-block" data-rellax-speed="0" style="bottom: -0.75rem; right: -0.75rem; width: 98%; height: 98%; z-index: 0;"></div>
                            <div class="card">
                                <div class="card-body px-6 py-5">
                                    <figure class="card-img-top"><img class="img-fluid" src="<?= safe_media('thumbnails', $item->thumbnail) ?>" alt="" /></figure>
                                    <h4 class="mb-1"><?= $item->title ?></h4>
                                    <a href="<?= base_url('innovations/' . hashids($item->id)) ?>">Lihat Inovasi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <?php if ($pager->getPageCount() > 1) : ?>
                <nav class="d-flex" aria-label="pagination">
                    <?= $pager->links('default', 'sandbox_post') ?>
                </nav>
            <?php endif ?>
        </div>
    </section>
<?php endif ?>
<?= $this->endSection() ?>

<?= $this->section('lowerbody') ?>
<script src="//cdn.jsdelivr.net/npm/masonry-layout@4.2.2/masonry.min.js"></script>
<?= $this->endSection() ?>
