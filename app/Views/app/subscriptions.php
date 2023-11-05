<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable" data-serverside="<?= append_url(null, 'datatable', $settings) ?>" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Email</th>
                        <th>Tanggal</th>
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
        data: "email"
    }, {
        data: "created_at"
    }, {
        data: "action",
        orderable: false
    }];
</script>
<?= $this->endSection() ?>
