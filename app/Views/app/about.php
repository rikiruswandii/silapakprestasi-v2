<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <?= form_open(append_url(null, 'save', $settings), ['class' => 'card']) ?>
    <div class="card-body">
        <textarea class="form-control full-editor" name="content"><?= $content ?></textarea>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
