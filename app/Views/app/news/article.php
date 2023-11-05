<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('button') ?>
<div class="col-auto ms-auto d-print-none">
    <div class="btn-list">
        <a href="<?= append_url(null, 'add', $settings) ?>" class="btn btn-primary d-none d-sm-inline-block">
            <?= tabler_icon('plus') ?>
            Tambah Artikel
        </a>
        <a href="<?= append_url(null, 'add', $settings) ?>" class="btn btn-primary d-sm-none btn-icon" aria-label="Tambah Artikel">
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
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Diterbitkan</th>
                        <th>Terakhir Diubah</th>
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
<?= $this->include('app/_includes/delete-modal') ?>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script type="text/javascript">
    const dtColumn = [{
        data: "no",
        orderable: false
    }, {
        data: "title"
    }, {
        data: "category"
    }, {
        data: "created_at"
    }, {
        data: "updated_at"
    }, {
        data: "action",
        orderable: false
    }];
</script>
<?= $this->endSection() ?>
