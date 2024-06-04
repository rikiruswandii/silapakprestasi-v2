<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-md-10 col-xl-8 mx-auto">
                <div class="post-header">
                    <h1 class="display-1 mb-4"><?= $page ?></h1>
                    <nav class="d-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Informasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tentang</li>
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
                        <div class="card-body">
                            <div class="classic-view">
                                <article class="post">
                                    <div class="post-content mb-5">
                                        <?= $content ?>
                                    </div>

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
