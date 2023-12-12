<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('headtag') ?>
<link rel="preload" href="<?= base_url('assets/css/fonts/thicccboi.css') ?>" as="style" onload="this.rel='stylesheet'">
<style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
            Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }

    #chartdiv,
    #chart-div {
        width: 100%;
        max-width: 100%;
        height: 350px;
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
                <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0"><?= $settings->app_header ?></h1>
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
                <h3 class="display-4 mb-10 px-xl-10">Layanan yang kami paparkan dirancang khusus untuk memenuhi kebutuhan kamu.</h3>
            </div>
        </div>

        <div class="position-relative">
            <div class="shape rounded-circle bg-soft-blue rellax w-16 h-16" data-rellax-speed="1" style="bottom: -0.5rem; right: -2.2rem; z-index: 0;"></div>
            <div class="shape bg-dot primary rellax w-16 h-17" data-rellax-speed="1" style="top: -0.5rem; left: -2.5rem; z-index: 0;"></div>
            <div class="row gx-md-5 gy-5 text-center">
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/list.svg') ?>" class="svg-inject icon-svg icon-svg-md text-yellow mb-3" alt="" />
                            <h4>Peta Investasi</h4>
                            <p class="mb-2">Lapangan usaha & komoditas strategi yang menjadi potensi di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('maps') ?>" class="more hover link-yellow">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/megaphone.svg') ?>" class="svg-inject icon-svg icon-svg-md text-red mb-3" alt="" />
                            <h4>Promosi Investasi</h4>
                            <p class="mb-2">Promosi, penargetan dan fasilitasi investasi aktif oleh Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('investments') ?>" class="more hover link-red">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/user.svg') ?>" class="svg-inject icon-svg icon-svg-md text-green mb-3" alt="" />
                            <h4>Profil Layanan</h4>
                            <p class="mb-2">Profil dan detail layanan instansi-instansi yang ada di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('profiles') ?>" class="more hover link-green">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="<?= base_url('assets/img/icons/target.svg') ?>" class="svg-inject icon-svg icon-svg-md text-blue mb-3" alt="" />
                            <h4>Promosi Inovasi</h4>
                            <p class="mb-2">Daftar inovasi-inovasi yang dibangun oleh instansi di Kabupaten Purwakarta.</p>
                            <a href="<?= base_url('innovations') ?>" class="more hover link-blue">Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="wrapper bg-light">
    <div class="container pt-14 pt-md-16">
        <div id="chartdiv"></div>
    </div>
</section>
<section class="wrapper bg-light">
    <div class="container pt-14 pt-md-16">
        <div id="chart-div"></div>
    </div>
</section>

<section class=" wrapper bg-gradient-reverse-primary">
    <div class="container py-16 py-md-18">
        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-8 align-items-center">
            <div class="col-lg-7 order-lg-2">
                <figure>
                    <img class="w-auto" src="<?= base_url('assets/img/concept/concept3.png') ?>" srcset="<?= base_url('assets/img/concept/concept3@2x.png') ?> 2x" alt="" />
                </figure>
            </div>

            <div class="col-lg-5">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Analisis Sekarang!</h2>
                <h3 class="display-4 mb-5">Apakah kamu seorang investor? Lihat potensi para pelaku usaha sekarang.</h3>
                <p class="mb-7">Kamu dapat dengan mudah melihat potensi-potensi para pelaku usaha dengan <?= $settings->app_name ?>.</p>

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

<section class="wrapper bg-light">
    <div class="container py-14 pt-md-17 pb-md-15">
        <div class="row gx-md-8 gx-xl-12 gy-10 mb-14 mb-md-18 align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="card shadow-lg me-lg-6">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number">01</span></span>
                            </div>
                            <div>
                                <p class="mb-0">Memberikan kemudahan para pelaku usaha dan/atau masyarakat untuk mendapatkan informasi potensi dan peluang investasi dan informasi inovasi pelayanan publik.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg ms-lg-13 mt-6">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number">02</span></span>
                            </div>
                            <div>
                                <p class="mb-0">Meningkatkan minat pelaku usaha untuk melakukan investasi dan mengembangkan usaha.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-lg mx-lg-6 mt-6">
                    <div class="card-body p-6">
                        <div class="d-flex flex-row">
                            <div>
                                <span class="icon btn btn-circle btn-lg btn-soft-primary disabled me-4"><span class="number">03</span></span>
                            </div>
                            <div>
                                <p class="mb-0">Mendapatkan fasilitas untuk promosi dan pemasaran produk unggulan .</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Manfaat Kami</h2>
                <h3 class="display-4 mb-5">Berikut adalah 3 manfaat yang kami berikan.</h3>
                <p>Terdapat 3 manfaat yang dapat kami berikan untuk para pelaku usaha dan/atau masyarakat berdasarkan hasil indetifikasi masalah yang dihadapi oleh DPMPTSP Kabupaten Purwakarta sebelumnya.</p>
                <p class="mb-6">Dan masalah-masalah tersebut dapat dengan mudah ditangani dengan <?= $settings->app_name ?> ini.</p>
                <a href="#what-we-do" class="btn btn-primary rounded-pill mb-0 scroll">Selengkapnya</a>
            </div>
        </div>

        <div class="row gx-lg-8 gx-xl-12 gy-10 mb-10 mb-md-14 align-items-center">
            <div class="col-lg-7">
                <figure>
                    <img class="w-auto" src="<?= base_url('assets/img/concept/concept5.png') ?>" srcset="<?= base_url('assets/img/concept/concept5@2x.png') ?> 2x" alt="" />
                </figure>
            </div>

            <div class="col-lg-5">
                <h2 class="fs-16 text-uppercase text-muted mb-3">Perlu Informasi Tambahan?</h2>
                <h3 class="display-4 mb-3">Yuk ngobrol ...</h3>
                <p>Jika kamu memiliki pertanyaan tentang <?= $settings->app_name ?>, silakan hubungi tim kami. Kami akan dengan senang hati membantu kamu sesegera mungkin.</p>
                <a href="<?= base_url('contact-us') ?>" class="btn btn-primary rounded-pill mt-2">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/plugins/forceDirected.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    /**
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    am4core.useTheme(am4themes_animated);

    var chart = am4core.create("chartdiv", am4charts.PieChart);
    chart.hiddenState.properties.opacity = 0;

    chart.data = [{
            country: "Lithuania",
            value: 401
        },
        {
            country: "Czech Republic",
            value: 300
        },
        {
            country: "Ireland",
            value: 200
        },
        {
            country: "Germany",
            value: 165
        },
        {
            country: "Australia",
            value: 139
        },
        {
            country: "Austria",
            value: 128
        }
    ];
    chart.radius = am4core.percent(70);
    chart.innerRadius = am4core.percent(40);
    chart.startAngle = 180;
    chart.endAngle = 360;

    var series = chart.series.push(new am4charts.PieSeries());
    series.dataFields.value = "value";
    series.dataFields.category = "country";

    series.slices.template.cornerRadius = 10;
    series.slices.template.innerCornerRadius = 7;
    series.slices.template.draggable = true;
    series.slices.template.inert = true;

    series.hiddenState.properties.startAngle = 90;
    series.hiddenState.properties.endAngle = 90;

    chart.legend = new am4charts.Legend();
</script>
<script>
    /**
     * ---------------------------------------
     * This demo was created using amCharts 4.
     *
     * For more information visit:
     * https://www.amcharts.com/
     *
     * Documentation is available at:
     * https://www.amcharts.com/docs/v4/
     * ---------------------------------------
     */

    am4core.useTheme(am4themes_animated);

    var chart = am4core.create("chart-div", am4plugins_forceDirected.ForceDirectedTree);
    chart.legend = new am4charts.Legend();

    var networkSeries = chart.series.push(new am4plugins_forceDirected.ForceDirectedSeries())

    networkSeries.data = [{
        name: 'Flora',
        fixed: true,
        x: am4core.percent(20),
        y: am4core.percent(50),
        children: [{
            name: 'Black Tea',
            value: 1
        }, {
            name: 'Floral',
            children: [{
                name: 'Chamomile',
                value: 1
            }, {
                name: 'Rose',
                value: 1
            }, {
                name: 'Jasmine',
                value: 1
            }]
        }]
    }, {
        name: 'Fruity',
        fixed: true,
        x: am4core.percent(40),
        y: am4core.percent(50),
        children: [{
            name: 'Berry',
            children: [{
                name: 'Blackberry',
                value: 1
            }, {
                name: 'Raspberry',
                value: 1
            }, {
                name: 'Blueberry',
                value: 1
            }, {
                name: 'Strawberry',
                value: 1
            }]
        }, {
            name: 'Dried Fruit',
            children: [{
                name: 'Raisin',
                value: 1
            }, {
                name: 'Prune',
                value: 1
            }]
        }, {
            name: 'Other Fruit',
            children: [{
                name: 'Coconut',
                value: 1
            }, {
                name: 'Cherry',
                value: 1
            }, {
                name: 'Pomegranate',
                value: 1
            }, {
                name: 'Pineapple',
                value: 1
            }, {
                name: 'Grape',
                value: 1
            }, {
                name: 'Apple',
                value: 1
            }, {
                name: 'Peach',
                value: 1
            }, {
                name: 'Pear',
                value: 1
            }]
        }, {
            name: 'Citrus Fruit',
            children: [{
                name: 'Grapefruit',
                value: 1
            }, {
                name: 'Orange',
                value: 1
            }, {
                name: 'Lemon',
                value: 1
            }, {
                name: 'Lime',
                value: 1
            }]
        }]
    }, {
        name: 'Other',
        fixed: true,
        x: am4core.percent(60),
        y: am4core.percent(50),
        children: [{
            name: 'Papery/Musty',
            children: [{
                name: 'Stale',
                value: 1
            }, {
                name: 'Cardboard',
                value: 1
            }, {
                name: 'Papery',
                value: 1
            }, {
                name: 'Woody',
                value: 1
            }, {
                name: 'Moldy/Damp',
                value: 1
            }, {
                name: 'Musty/Dusty',
                value: 1
            }, {
                name: 'Musty/Earthy',
                value: 1
            }, {
                name: 'Animalic',
                value: 1
            }, {
                name: 'Meaty Brothy',
                value: 1
            }, {
                name: 'Phenolic',
                value: 1
            }]
        }, {
            name: 'Chemical',
            children: [{
                name: 'Bitter',
                value: 1
            }, {
                name: 'Salty',
                value: 1
            }, {
                name: 'Medicinal',
                value: 1
            }, {
                name: 'Petroleum',
                value: 1
            }, {
                name: 'Skunky',
                value: 1
            }, {
                name: 'Rubber',
                value: 1
            }]
        }]
    }, {
        name: 'Roasted',
        fixed: true,
        x: am4core.percent(80),
        y: am4core.percent(50),
        children: [{
            name: 'Pipe Tobacco',
            value: 1
        }, {
            name: 'Tobacco',
            value: 1
        }, {
            name: 'Burnt',
            children: [{
                name: 'Acrid',
                value: 1
            }, {
                name: 'Ashy',
                value: 1
            }, {
                name: 'Smoky',
                value: 1
            }, {
                name: 'Brown, Roast',
                value: 1
            }]
        }, {
            name: 'Cereal',
            children: [{
                name: 'Grain',
                value: 1
            }, {
                name: 'Malt',
                value: 1
            }]
        }]

    }];

    networkSeries.dataFields.linkWith = "linkWith";
    networkSeries.dataFields.name = "name";
    networkSeries.dataFields.id = "name";
    networkSeries.dataFields.value = "value";
    networkSeries.dataFields.children = "children";
    networkSeries.dataFields.fixed = "fixed";

    networkSeries.nodes.template.propertyFields.x = "x";
    networkSeries.nodes.template.propertyFields.y = "y";

    networkSeries.nodes.template.tooltipText = "{name}";
    networkSeries.nodes.template.fillOpacity = 1;

    networkSeries.nodes.template.label.text = "{name}"
    networkSeries.fontSize = 8;
    networkSeries.maxLevels = 3;
    networkSeries.nodes.template.label.hideOversized = true;
    networkSeries.nodes.template.label.truncate = true;
</script>
<?= $this->endSection() ?>