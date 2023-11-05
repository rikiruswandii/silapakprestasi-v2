<div class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar navbar-light">
            <div class="container-xl">
                <ul class="navbar-nav">
                    <?php foreach (sidebars() as $sidebar) : ?>
                        <?php if (count($sidebar->children) > 0 && access_granted($sidebar->permission, $userdata)) : ?>
                            <li class="nav-item dropdown <?= $sidebar->active ?>">
                                <a class="nav-link dropdown-toggle" href="#navbar-extra" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <?= tabler_icon($sidebar->icon) ?>
                                    </span>
                                    <span class="nav-link-title">
                                        <?= $sidebar->name ?>
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <?php foreach ($sidebar->children as $children) : ?>
                                        <?php if (access_granted($children->permission, $userdata)) : ?>
                                            <a class="dropdown-item <?= $children->active ?>" href="<?= base_url($settings->app_prefix . $children->url) ?>">
                                                <?= $children->name ?>
                                            </a>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </div>
                            </li>
                        <?php elseif (access_granted($sidebar->permission, $userdata)) : ?>
                            <li class="nav-item <?= $sidebar->active ?>">
                                <a class="nav-link" href="<?= base_url($settings->app_prefix . $sidebar->url) ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <?= tabler_icon($sidebar->icon) ?>
                                    </span>
                                    <span class="nav-link-title">
                                        <?= $sidebar->name ?>
                                    </span>
                                </a>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
</div>
