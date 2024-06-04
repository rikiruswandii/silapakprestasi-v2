<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <?= form_open_multipart($settings->app_prefix . '/innovations/update/' . $detail->id, ['class' => 'card']) ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" value="<?= $detail->title ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konten</label>
                    <textarea name="content" class="form-control full-editor"><?= $detail->content ?></textarea>
                </div>
                <div class="mb-0">
                    <label class="form-label">PDF</label>
                    <input type="file" name="pdf" data-default-file="<?= safe_media('contents', $detail->pdf) ?>" class="dropify" data-show-remove="false" data-allowed-file-extensions="pdf">
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="mb-3">
                    <label class="form-label">Instansi</label>
                    <select name="instance" class="form-control select2">
                        <option value="">Pilih Instansi</option>
                        <?php foreach ($instances as $item) : ?>
                            <option value="<?= $item->id ?>" <?= ($detail->instance == $item->id ? 'selected' : '') ?>><?= $item->title ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-0">
                    <label class="form-label">Gambar Mini</label>
                    <input type="file" name="thumbnail" data-default-file="<?= safe_media('thumbnails', $detail->thumbnail) ?>" class="dropify" data-show-remove="false" data-allowed-file-extensions="png jpg jpeg gif">
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
