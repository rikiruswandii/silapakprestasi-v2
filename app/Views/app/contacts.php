<?= $this->extend('app/_layouts/app') ?>

<?= $this->section('body') ?>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable" data-serverside="<?= append_url(null, 'datatable', $settings) ?>" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
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
<div class="modal modal-blur fade" id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content" data-page="Pesan">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pesan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <div class="form-control" id="detail-name"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Surel</label>
                    <div class="form-control" id="detail-email"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <div class="form-control" id="detail-phone"></div>
                </div>
                <div class="mb-0">
                    <label class="form-label">Pesan</label>
                    <div class="form-control" id="detail-message"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0)" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Tutup
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->include('app/_includes/delete-modal') ?>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script type="text/javascript">
    const dtColumn = [{
        data: "no",
        orderable: false
    }, {
        data: "name"
    }, {
        data: "created_at"
    }, {
        data: "action",
        orderable: false
    }];

    $(document).on('click', '.detail-button', function(evt) {
        evt.preventDefault();

        let formSection = $('#modal-detail .modal-content');
        let pageTitle = formSection.data('page');

        let thisData = $(this).data();
        for (data in thisData) {
            let selector = '#detail-' + data;

            if ((thisData[data]).toString().trim() == '') {
                formSection.find(selector).parent().hide();
            } else {
                formSection.find(selector).parent().show();
            }

            if (formSection.find(selector).length > 0) {
                let value = (thisData[data]).toString();

                formSection.find(selector).html(value);
                formSection.find(selector).attr('src', value);
            }
        }

        formSection.find('.modal-title').html('Detail ' + pageTitle);
    });
</script>
<?= $this->endSection() ?>
