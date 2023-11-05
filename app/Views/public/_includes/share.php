<div class="dropdown share-dropdown btn-group">
    <button class="btn btn-sm btn-red rounded-pill btn-icon btn-icon-start dropdown-toggle mb-0 me-0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="uil uil-share-alt me-2"></i>
        Bagikan
    </button>

    <div class="dropdown-menu">
        <?= anchor_popup(
            'https://twitter.com/intent/tweet?url=' . current_url(),
            '<i class="uil uil-twitter"></i> Twitter',
            ['class' => 'dropdown-item']
        ) ?>
        <?= anchor_popup(
            'https://www.facebook.com/sharer/sharer.php?u=' . current_url(),
            '<i class="uil uil-facebook-f"></i> Facebook',
            ['class' => 'dropdown-item']
        ) ?>
        <?= anchor_popup(
            'https://www.linkedin.com/shareArticle?mini=true&url=' . current_url(),
            '<i class="uil uil-linkedin"></i> LinkedIn',
            ['class' => 'dropdown-item']
        ) ?>
    </div>
</div>
