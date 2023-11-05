<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <?php if (isset($parent)) : ?>
                    <div class="page-pretitle">
                        <?= $parent ?>
                    </div>
                <?php endif ?>
                <h2 class="page-title">
                    <?= $page ?>
                </h2>
                <?php if (isset($gallery)) : ?>
                    <div class="text-muted mt-1"><?= $offset ?>-<?= $limit ?> dari <?= $total ?> foto</div>
                <?php endif ?>
            </div>

            <?= $this->renderSection('button') ?>
        </div>
    </div>
</div>
