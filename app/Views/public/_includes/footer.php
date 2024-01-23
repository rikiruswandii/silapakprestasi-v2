<footer class="bg-dark text-inverse">
    <div class="container py-13 py-md-15">
        <div class="row gy-6 gy-lg-0">
            <div class="col-md-4 col-lg-3">
                <div class="widget">
                    <img class="mb-4" src="<?= base_url('assets/img/logo-investasi-purwakarta (1).png') ?>" srcset="<?= base_url('logo-investasi-purwakarta (1).png') ?> 2x" alt="<?= $settings->app_title ?>" />
                    <p class="mb-4">
                        &copy; <?= date('Y') ?> <?= $settings->app_name ?>.
                        <br class="d-none d-lg-block" />
                        Seluruh hak cipta.
                    </p>

                    <nav class="nav social social-white">
                        <a href="javascript:void(0)"><i class="uil uil-twitter"></i></a>
                        <a href="javascript:void(0)"><i class="uil uil-facebook-f"></i></a>
                        <a href="javascript:void(0)"><i class="uil uil-instagram"></i></a>
                        <a href="javascript:void(0)"><i class="uil uil-youtube"></i></a>
                    </nav>
                </div>
            </div>

            <div class="col-md-5 col-lg-4">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Hubungi Kami</h4>
                    <address class="pe-xl-12 pe-xxl-15"><?= $settings->contact_address ?></address>
                    <?= safe_mailto($settings->contact_email, $settings->contact_email) ?>
                    <br />
                    <?= $settings->contact_phone ?>
                </div>
            </div>

            <div class="col-md-3 col-lg-2">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Informasi</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a href="<?= base_url('about') ?>">Tentang</a></li>
                        <li><a href="<?= base_url('news') ?>">Berita</a></li>
                        <li><a target="_blank" rel="nofollow, noindex" href="https://dpmptsp.purwakartakab.go.id/">DPMPTSP</a></li>
                        <li><a target="_blank" rel="nofollow, noindex" href="https://dpmptsp.purwakartakab.go.id/data/regulasi">Regulasi</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-12 col-lg-3">
                <div class="widget">
                    <h4 class="widget-title text-white mb-3">Berlangganan</h4>
                    <p class="mb-5">Dapatkan informasi terkini dan terbaru yang dikirimkan langsung ke kotak masuk Anda.</p>

                    <div class="newsletter-wrapper">
                        <div>
                            <?= form_open('api/subscribe/' . hashids(mt_rand()), ['class' => 'validate dark-fields']) ?>
                            <div>
                                <div class="mc-field-group input-group form-label-group">
                                    <input type="email" name="email" class="required email form-control" placeholder="Alamat Surel" id="email-newsletter">
                                    <label for="email-newsletter">Alamat Surel</label>
                                    <input type="submit" value="Kirim" name="subscribe" class="btn btn-primary">
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
