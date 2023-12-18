<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<link rel="preload" href="<?= base_url('assets/css/fonts/thicccboi.css') ?>" as="style" onload="this.rel='stylesheet'">
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
            Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }

    #chartdiv {
        width: 100%;
        max-width: 100%;
        height: 500px;
    }

    #chart-div {
        width: 100%;
        max-width: 100%;
        height: 50vh;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="wrapper bg-gradient-primary">
    <div class="container pt-10 pt-md-14 pb-8 text-center">
        <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
            <div class="col-lg-7">
                <figure>
                    <img class="w-auto" src="<?= base_url('assets/img/concept/mpp.png') ?>" />
                </figure>
            </div>

            <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start">
                <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0 gradient-text"><?= $settings->app_header ?></h1>
                <p class="lead fs-lg mb-7"><?= $settings->app_tagline ?></p>
                <span><a href="#what-we-do" class="btn btn-primary rounded-pill me-2 scroll">Selengkapnya</a></span>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light" id="what-we-do">
    <div class="container pt-14 pt-md-16">
        <div class="row text-center">
            <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Apa Yang Bisa Didapatkan?</h2>
                <h3 class="display-4 mb-10 px-xl-10">Layanan yang kami paparkan dirancang khusus untuk memenuhi kebutuhan anda.</h3>
            </div>
        </div>

        <div class="position-relative">
            <div class="shape rounded-circle bg-soft-blue rellax w-16 h-16" data-rellax-speed="1" style="bottom: -0.5rem; right: -2.2rem; z-index: 0;"></div>
            <div class="shape bg-dot primary rellax w-16 h-17" data-rellax-speed="1" style="top: -0.5rem; left: -2.5rem; z-index: 0;"></div>
            <div class="row gx-md-5 gy-5 text-center">
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg bg-baru ">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/list.svg') ?>" class="svg-inject icon-svg icon-svg-md text-yellow mb-3" alt="" />
                            <h4>Peta Investasi</h4>
                            <p class="mb-2 text-light">Lapangan usaha & komoditas strategi yang menjadi potensi di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('maps') ?>" class="more bg-warning hover  link-light border-light rounded">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg bg-baru">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/megaphone.svg') ?>" class="svg-inject icon-svg icon-svg-md text-red mb-3" alt="" />
                            <h4>Promosi Investasi</h4>
                            <p class="mb-2 text-light">Promosi, penargetan dan fasilitasi investasi aktif oleh Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('investments') ?>" class="more hover bg-red link-light rounded">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg bg-baru">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/user.svg') ?>" class="svg-inject icon-svg icon-svg-md text-green mb-3" alt="" />
                            <h4>Profil Layanan</h4>
                            <p class="mb-2 text-light">Profil dan detail layanan instansi-instansi yang ada di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('profiles') ?>" class="more hover bg-success  link-light rounded">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg bg-baru">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/target.svg') ?>" class="svg-inject icon-svg icon-svg-md text-blue mb-3" alt="" />
                            <h4>Promosi Inovasi</h4>
                            <p class="mb-2 text-light">Daftar inovasi-inovasi yang dibangun oleh instansi di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('innovations') ?>" class="more hover bg-info link-light rounded">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class=" wrapper bg-light">
    <div class="container py-16 py-md-18">
        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-8 align-items-center">
            <div class="col-lg-7 order-lg-2">
                <figure>
                    <img class="w-auto" src="<?= base_url('assets/img/investments/investments.png') ?>" srcset="<?= base_url('assets/img/investments/investments@2x.png') ?> 2x" alt="" />
                </figure>
            </div>

            <div class="col-lg-5">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Analisis Sekarang!</h2>
                <h3 class="display-4 mb-5">Apakah anda seorang investor? Lihat potensi para pelaku usaha sekarang.</h3>
                <p class="mb-7">Anda dapat dengan mudah melihat potensi-potensi para pelaku usaha dengan <?= $settings->app_name ?>.</p>

                <div class="row">
                    <div class="col-lg-9">
                        <form action="<?= base_url('search') ?>" method="GET">
                            <div class="form-label-group input-group">
                                <input type="search" name="s" class="form-control" placeholder="Cari Usaha/Pengusaha" id="search-msme" required="">
                                <label for="search-msme">Cari Usaha/Pengusaha</label>
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-gradient-reverse-primary ">
    <div class="container py-5 py-md-5 mb-0">
        <div class="display-4 mt-4 mb-8">Promosi <strong class="text-dark">Investasi</strong></div>
        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-8 align-items-center">
            <div class="col-12">
                <div class="blog grid grid-view">
                    <div class="row isotope gx-md-8 gy-8 mb-8">
                        <?php foreach ($investments as $item) : ?>
                            <article class="item post col-md-3 ">
                                <div class="card bg-baru shadow-lg">
                                    <figure class="card-img-top overlay overlay1 hover-scale">
                                        <a href="<?= base_url('investment/' . $item->slug) ?>">
                                            <img src="<?= safe_media('thumbnails', $item->thumbnail) ?>" alt="<?= $item->title ?>" />
                                        </a>
                                        <figcaption>
                                            <h5 class="from-top mb-0">Selengkapnya</h5>
                                        </figcaption>
                                    </figure>
                                    <div class="card-body">
                                        <div class="post-header">
                                            <div class="post-category text-line text-light">
                                                <a href="<?= base_url('investments/' . $item->slugsector) ?>" class="hover text-light" rel="category"><?= $item->sector ?? "Promosi Investasi" ?></a>
                                            </div>
                                            <h2 class="post-title h3 mt-1 mb-3">
                                                <a class="link-dark" href="<?= base_url('investment/' . $item->slug) ?>">
                                                    <?= $item->title ?>
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="post-content text-light">
                                            <p><?= cuttext(strip_tags($item->content)) ?></p>
                                        </div>
                                    </div>

                                    <div class="card-footer border border-primary-subtle">
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
            </div>
            <div class="container mt-0">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="investments" class="btn btn-primary btn-sm">Lihat Semua Promosi</a>
                    </div>
                </div>
            </div>
            <hr class="mb-0" />
        </div>
        <div class="display-4 mt-4 mb-8">Promosi <strong class="text-dark">Inovasi</strong></div>
        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-8 align-items-center">
            <div class="col-12">
                <div class="blog grid grid-view">
                    <div class="row isotope gx-md-8 gy-8 mb-8">
                        <?php foreach ($innovations as $item) : ?>
                            <article class="item post col-md-3">
                                <div class="card shadow-lg bg-baru">
                                    <figure class="card-img-top overlay overlay1 hover-scale border border-primary-subtle border-bottom-0">
                                        <a href="<?= base_url('innovation/' . $item->slug) ?>">
                                            <img src="<?= safe_media('thumbnails', $item->thumbnail) ?>" alt="<?= $item->title ?>" />
                                        </a>
                                        <figcaption>
                                            <h5 class="from-top mb-0">Selengkapnya</h5>
                                        </figcaption>
                                    </figure>
                                    <div class="card-body">
                                        <div class="post-header">
                                            <div class="post-category text-line text-light">
                                                <a href="<?= $item->category ?>" class="hover text-light" rel="category"><?= $item->instance ?></a>
                                            </div>
                                            <h2 class="post-title h3 mt-1 mb-3">
                                                <a class="link-dark" href="<?= base_url('innovation/' . $item->slug) ?>">
                                                    <?= $item->title ?>
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="post-content text-light">
                                            <p><?= cuttext(strip_tags($item->content)) ?></p>
                                        </div>
                                    </div>

                                    <div class="card-footer border border-primary-subtle">
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
            </div>
            <div class="container mt-0">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="innovations" class="btn btn-primary btn-sm">Lihat Semua Promosi</a>
                    </div>
                </div>
            </div>
            <hr class="mb-0" />
            <div id="chartdiv" class="mb-1 mt-0" style="font-size: 12px;"></div>
            <div id="chart-div" class="mb-0"></div>
        </div>
    </div>
</section>

<section class="wrapper bg-light">
    <div class="container py-14 pt-md-17 pb-md-15">
        <div class="row gx-md-8 gx-xl-12 gy-10 mb-14 mb-md-18 align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="card me-lg-6 custom-bg-transparent shadow-lg">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number text-dark">01</span></span>
                            </div>
                            <div>
                                <p class="mb-0 text-white">Memberikan kemudahan para pelaku usaha dan/atau masyarakat untuk mendapatkan informasi potensi dan peluang investasi dan informasi inovasi pelayanan publik.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg ms-lg-13 mt-6 custom-bg-transparent">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number text-dark">02</span></span>
                            </div>
                            <div>
                                <p class="mb-0 text-white">Meningkatkan minat pelaku usaha untuk melakukan investasi dan mengembangkan usaha.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg mx-lg-6 mt-6 custom-bg-transparent">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number text-dark">03</span></span>
                            </div>
                            <div>
                                <p class="mb-0 text-white">Mendapatkan fasilitas untuk promosi dan pemasaran produk unggulan .</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Manfaat Kami</h2>
                <h3 class="display-4 mb-5">Berikut adalah 3 manfaat yang kami berikan.</h3>
                <p>Terdapat 3 manfaat yang dapat kami berikan untuk para pelaku usaha dan/atau masyarakat berdasarkan hasil identifikasi masalah yang dihadapi oleh DPMPTSP Kabupaten Purwakarta sebelumnya.</p>
                <p class="mb-6">Dan masalah-masalah tersebut dapat dengan mudah ditangani dengan <?= $settings->app_name ?> ini.</p>
                <a href="#what-we-do" class="btn btn-primary rounded-pill mb-0 scroll">Selengkapnya</a>
            </div>

        </div>

        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-10 mb-md-14 align-items-center">
            <div class="col-lg-7">
                <figure>
                    <img class="w-auto" src="<?= base_url('assets/img/investments/investments9.png') ?>" srcset="<?= base_url('assets/img/investments/investments9@2x.png') ?> 2x" alt="" />
                </figure>
            </div>

            <div class="col-lg-5">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Perlu Informasi Tambahan?</h2>
                <h3 class="display-4 mb-3">Yuk ngobrol ...</h3>
                <p>Jika anda memiliki pertanyaan tentang <?= $settings->app_name ?>, silakan hubungi tim kami. Kami akan dengan senang hati membantu kamu sesegera mungkin.</p>
                <a href="<?= base_url('contact-us') ?>" class="btn btn-primary rounded-pill mt-2">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/forceDirected.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="<?= base_url('assets/js/chartBalon.js') ?>"></script>
<script src="<?= base_url('assets/js/chartMeter.js') ?>"></script>
<?= $this->endSection() ?>