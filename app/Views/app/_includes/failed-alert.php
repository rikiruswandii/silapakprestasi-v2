<?php if (session()->getFlashdata('failed')) : ?>
    <div class="notyf" data-type="error" data-message="<?= session()->getFlashdata('failed') ?>" data-duration="5000" data-ripple="false" data-dismissible="true" data-x="right" data-y="top"></div>
<?php endif ?>
