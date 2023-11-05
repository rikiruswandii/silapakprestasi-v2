<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <?= form_open_multipart($settings->app_prefix . '/investments/update/' . $detail->id, ['class' => 'card']) ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control" value="<?= $detail->title ?>">
                </div>
                <div class="mb-0">
                    <label class="form-label">Konten</label>
                    <textarea name="content" class="form-control full-editor"><?= $detail->content ?></textarea>
                </div>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <div class="mb-3">
                    <label class="form-label">Sektor</label>
                    <select name="sector" class="form-control select2">
                        <option value="">-- Pilih Sektor --</option>
                        <?php foreach ($sectors as $sector) : ?>
                            <option value="<?= $sector->id ?>" <?= $sector->slug === $detail->slugsector ? 'selected' : '' ?>><?= $sector->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3" style="display: none;">
                    <label class="form-label">Sub</label>
                    <select name="sub" class="form-control select2">
                        <option value="">-- Pilih Sub --</option>
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

<?= $this->section('javascript') ?>
<script type="text/javascript">
    const idsub = "<?= $detail->idsector ?>";

    const check = () => {
        let value = $("[name=\"sector\"]").val();
        $("[name=\"sub\"]").parent().hide();
        $("[name=\"sub\"]").val("");

        if (value.trim() !== '') {
            let $html = $('<div class="loading-insert"><div class="uil-ring-css" style="transform: scale(0.79);"><div></div></div></div>');
            $("body").append($html);
        }

        $.ajax({
            method: "GET",
            dataType: "JSON",
            url: "<?= base_url($settings->app_prefix . '/investments/sectors') ?>",
            data: {
                id: value
            },
            success: function({
                data
            }) {
                $("[name=\"sub\"]").html("<option value=\"\">-- Pilih Sub --</option>").trigger("change");
                $("[name=\"sub\"]").val("");

                data.forEach(function(item) {
                    let option;

                    if (idsub === item.id) {
                        option = new Option(item.text, item.id, true, true);
                    } else {
                        option = new Option(item.text, item.id, false, false);
                    }

                    $("[name=\"sub\"]").append(option).trigger("change");
                });

                if (data.length <= 0) {
                    $("[name=\"sub\"]").parent().hide();
                } else {
                    $("[name=\"sub\"]").parent().show();
                }

                $('.loading-insert').remove();
            }
        });
    };

    $("[name=\"sector\"]").on("change", check);
    $(document).ready(check);
</script>
<?= $this->endSection() ?>
