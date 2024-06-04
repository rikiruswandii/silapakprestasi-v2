<?php if (session()->getFlashdata('success')) : ?>
    <div class="notyf" data-type="success" data-message="<?= session()->getFlashdata('success') ?>" data-duration="5000" data-ripple="false" data-dismissible="true" data-x="right" data-y="top"></div>
<?php endif ?>
