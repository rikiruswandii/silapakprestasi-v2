<div class="modal modal-blur fade" id="modal-danger" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <?= form_open('', ['class' => 'modal-content delete-modal-do-delete']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
        <div class="modal-status bg-danger"></div>

        <div class="modal-body text-center py-4">
            <?= tabler_icon('alert-triangle', ['mb-2', 'text-danger', 'icon-lg']) ?>
            <h3>Apakah kamu yakin?</h3>

            <div class="text-muted">
                Kamu yakin akan menghapus <span class="delete-modal-spesific-name" style="font-weight: bold;"></span>? Ini tidak akan bisa dikembalikan.
            </div>
        </div>

        <div class="modal-footer">
            <div class="w-100">
                <div class="row">
                    <div class="col">
                        <a href="javascript:void(0)" class="btn btn-white w-100" data-bs-dismiss="modal">Batal</a>
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-danger w-100">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>
