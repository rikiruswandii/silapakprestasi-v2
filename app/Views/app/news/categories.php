<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('button') ?>
<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        <a href="javascript:void(0)" class="add-button btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal-form">
            <?= tabler_icon('plus') ?>
            Tambah Kategori
        </a>
        <a href="javascript:void(0)" class="add-button btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-backdrop="static" data-bs-target="#modal-form" aria-label="Tambah Kategori">
            <?= tabler_icon('plus') ?>
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
                        <th>Kategori</th>
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
        <?= form_open('', [
            'class' => 'modal-content',
            'data-page' => $page,
            'data-insert' => append_url(null, 'insert', $settings),
            'data-update' => append_url(null, 'update', $settings)
        ]) ?>
        <div class="modal-header">
            <h5 class="modal-title">Tambah Kategori</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="mb-0">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" name="name">
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
        data: 'action',
        orderable: false
    }];
</script>
<?= $this->endSection() ?>
