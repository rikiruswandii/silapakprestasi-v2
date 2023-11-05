<?= $this->extend('public/_layouts/default') ?>

<?= $this->section('content') ?>
<section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-19 pt-md-14 pb-md-20 text-center">
        <div class="row">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6 col-xxl-5 mx-auto">
                <h1 class="display-1 mb-3"><?= $page ?></h1>
                <nav class="d-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Utama</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Hubungi Kami</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="wrapper bg-light angled upper-end">
    <div class="container py-14 py-md-16">
        <div class="row gy-10 gx-lg-8 gx-xl-12 mb-16 align-items-center">
            <div class="col-lg-7 position-relative">
                <div class="shape bg-dot primary rellax w-18 h-18" data-rellax-speed="1" style="top: 0; left: -1.4rem; z-index: 0;"></div>
                <div class="row gx-md-5 gy-5">
                    <div class="col-md-6">
                        <figure class="rounded mt-md-10 position-relative">
                            <img src="https://dpmptsp.purwakartakab.go.id/assets/upload/gallery/ef63973549dd18ab118e862edb84f69f.jpeg" alt="">
                        </figure>
                    </div>

                    <div class="col-md-6">
                        <div class="row gx-md-5 gy-5">
                            <div class="col-md-12 order-md-2">
                                <figure class="rounded">
                                    <img src="https://dpmptsp.purwakartakab.go.id/assets/upload/gallery/6db21785292e9e350adf6c252e088b70.jpeg" alt="">
                                </figure>
                            </div>

                            <div class="col-md-10">
                                <div class="card bg-pale-primary text-center counter-wrapper">
                                    <div class="card-body py-11">
                                        <h3 class="counter text-nowrap">912708+</h3>
                                        <p class="mb-0">Masyarakat Puas</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <h2 class="display-4 mb-8">Belum yakin? Mari bangun sesuatu yang hebat bersama-sama.</h2>
                <div class="d-flex flex-row">
                    <div>
                        <div class="icon text-primary fs-28 me-6 mt-n1">
                            <i class="uil uil-location-pin-alt"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">Alamat</h5>
                        <address>
                            <?= $settings->contact_address ?>
                        </address>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div>
                        <div class="icon text-primary fs-28 me-6 mt-n1">
                            <i class="uil uil-phone-volume"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">Telepon</h5>
                        <p><?= $settings->contact_phone ?></p>
                    </div>
                </div>
                <div class="d-flex flex-row">
                    <div>
                        <div class="icon text-primary fs-28 me-6 mt-n1">
                            <i class="uil uil-envelope"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1">Surat Elektronik</h5>
                        <p class="mb-0">
                            <?= safe_mailto($settings->contact_email, $settings->contact_email, ['class' => 'link-body']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                <h2 class="display-4 mb-3 text-center">Berikan Kami Satu Baris</h2>
                <p class="lead text-center mb-10">Hubungi kami melalui formulir dan kami akan segera menghubungi Anda kembali.</p>
                <form class="contact-form" method="post" action="<?= base_url('api/contact-us') ?>">
                    <div class="messages"></div>

                    <div class="controls">
                        <div class="row gx-4">
                            <div class="col-md-6">
                                <div class="form-label-group mb-4">
                                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Jane" required="required" data-error="Nama depan dibutuhkan.">
                                    <label for="form_name">Nama Depan *</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-label-group mb-4">
                                    <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Doe" required="required" data-error="Nama belakang dibutuhkan.">
                                    <label for="form_lastname">Nama Belakang *</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-label-group mb-4">
                                    <input id="form_email" type="email" name="email" class="form-control" placeholder="jane.doe@example.com" required="required" data-error="Diperlukan email yang valid.">
                                    <label for="form_email">Surel *</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-label-group mb-4">
                                    <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Nomor telepon Anda">
                                    <label for="form_phone">Telepon</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-label-group mb-4">
                                    <textarea id="form_message" name="message" class="form-control" placeholder="Pesan Anda" rows="5" required="required" data-error="Pesan dibutuhkan."></textarea>
                                    <label for="form_message">Pesan *</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Kirim">
                                <p class="text-muted"><strong>*</strong> Kolom ini wajib diisi.</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
