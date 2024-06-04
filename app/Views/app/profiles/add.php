<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <?= form_open_multipart($settings->app_prefix . '/profiles/insert', ['class' => 'card']) ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konten</label>
                    <textarea name="content" class="form-control full-editor"><?= old('content') ?></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">PDF</label>
                    <input type="file" name="pdf" class="dropify" data-show-remove="false" data-allowed-file-extensions="pdf">
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="mb-0">
                    <label class="form-label">Gambar Mini</label>
                    <input type="file" name="thumbnail" class="dropify" data-show-remove="false" data-allowed-file-extensions="png jpg jpeg gif">
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>
