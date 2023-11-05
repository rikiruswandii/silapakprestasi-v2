<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('button') ?>
<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        <a href="javascript:void(0)" class="add-button btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal-form">
            <?= tabler_icon('upload') ?>
            Unggah KMZ
        </a>
        <a href="javascript:void(0)" class="add-button btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal-form" aria-label="Unggah KMZ">
            <?= tabler_icon('upload') ?>
        </a>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable" data-serverside="<?= append_url(null, 'datatable', $settings) ?>" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Kecamatan</th>
                        <th></th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('modal') ?>
<div class="modal modal-blur fade" id="modal-form" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <?= form_open_multipart('', [
            'class' => 'modal-content',
            'data-page' => $page,
            'data-insert' => append_url(null, 'upload', $settings),
            'data-update' => append_url(null, 'update', $settings)
        ]) ?>
        <div class="modal-header">
            <h5 class="modal-title">Unggah KMZ</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe</label>
                <select name="type" class="form-control select2 tags">
                    <option value="">Pilih/Buat Tipe</option>
                    <?php foreach ($types as $item) : ?>
                        <option value="<?= $item->type ?>"><?= $item->type ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="district" class="form-label">Kecamatan</label>
                <select name="district" id="district" class="form-control select2">
                    <option value="">Pilih Kecamatan</option>
                    <?php foreach (districts() as $key => $val) : ?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Berkas</label>
                <input type="file" class="form-control" name="file">
            </div>
        </div>

        <div class="modal-footer">
            <a href="javascript:void(0)" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                Batal
            </a>
            <button type="submit" class="btn btn-primary ms-auto">
                Simpan
            </button>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= $this->include('app/_includes/delete-modal') ?>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script type="text/javascript">
    const dtColumn = [{
        data: 'no',
        orderable: false
    }, {
        data: 'name'
    }, {
        data: 'type'
    }, {
        data: 'district'
    }, {
        data: 'action',
        orderable: false
    }];
</script>
<?= $this->endSection() ?>
