<div class="w-100" style="background-color:#343f51;">
    <div class="container">
        <div class="row justify-content-between align-items-center px-1 py-1 d-flex"> <!-- Menambahkan kelas d-flex -->
            <div class="col-auto  d-flex align-items-center"> <!-- Mengubah ke col-auto -->
                <nav class="nav social social-white">
                    <a href="javascript:void(0)" class="text-light"><i class="uil uil-twitter fs-12"></i></a>
                    <a href="javascript:void(0)" class="text-light"><i class="uil uil-facebook-f fs-12"></i></a>
                    <a href="javascript:void(0)" class="text-light"><i class="uil uil-instagram fs-12"></i></a>
                    <a href="javascript:void(0)" class="text-light"><i class="uil uil-youtube fs-12"></i></a>
                </nav>
                <span class="text-light">| &nbsp;<?= safe_mailto($settings->contact_email, $settings->contact_email, 'class="text-light fs-12"') ?></span>
            </div>
            <div class="col-auto text-right"> <!-- Mengubah ke col-auto dan text-right -->
                <a href="/login" class="text-light fs-12 link-login">Login</a>                <!-- Menambahkan kelas text-right -->
            </div>
        </div>
    </div>
</div>