<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);

?>
<ul class="pagination">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                <span aria-hidden="true"><i class="uil uil-arrow-left"></i></span>
            </a>
        </li>
    <?php else : ?>
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                <span aria-hidden="true"><i class="uil uil-arrow-left"></i></span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach (array2object($pager->links()) as $link) : ?>
        <?php if ($link->active) : ?>
            <li class="page-item active">
                <a class="page-link" href="javascript:void(0)">
                    <?= $link->title ?>
                </a>
            </li>
        <?php else : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $link->uri ?>">
                    <?= $link->title ?>
                </a>
            </li>
        <?php endif ?>
    <?php endforeach ?>


    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                <span aria-hidden="true"><i class="uil uil-arrow-right"></i></span>
            </a>
        </li>
    <?php else : ?>
        <li class="page-item disabled">
            <a class="page-link" href="javascript:void(0)" aria-label="Next">
                <span aria-hidden="true"><i class="uil uil-arrow-right"></i></span>
            </a>
        </li>
    <?php endif ?>
</ul>
