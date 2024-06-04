<ul class="navbar-nav">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="javascript:void(0)">Investasi</a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('maps') ?>">Peta Potensi Investasi</a>
            </li>
            <li class="dropdown">
                <a href="<?= base_url('investments') ?>" class="dropdown-item dropdown-toggle">Promosi Investasi</a>
                <ul class="dropdown-menu">
                    <?php foreach (sectors() as $sector) : ?>
                        <?php if (count($sector->children) <= 0) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url('investments/' . $sector->slug) ?>" class="dropdown-item"><?= $sector->name ?></a>
                            </li>
                        <?php else : ?>
                            <li class="dropdown">
                                <a href="<?= base_url('investments/' . $sector->slug) ?>" class="dropdown-item dropdown-toggle"><?= $sector->name ?></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($sector->children as $child) : ?>
                                        <li class="nav-item">
                                            <a href="<?= base_url('investments/' . $sector->slug . '/' . $child->slug) ?>" class="dropdown-item"><?= $child->name ?></a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="javascript:void(0)">Pelayanan</a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('profiles') ?>">Profil Layanan Instansi</a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('innovations') ?>">Promosi Inovasi</a>
            </li>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="javascript:void(0)">Regulasi</a>
        <ul class="dropdown-menu">
            <?php foreach (regulations() as $field => $text) : ?>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-item dropdown-toggle"><?= $text ?></a>
                    <ul class="dropdown-menu">
                        <?php foreach (subregulations() as $slug => $sub) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url(implode('/', ['regulation', $field, $slug])) ?>" class="dropdown-item"><?= $sub ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </li>
            <?php endforeach ?>
        </ul>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="javascript:void(0)">Informasi</a>
        <ul class="dropdown-menu">
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('about') ?>">Tentang</a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('news') ?>">Berita</a>
            </li>
            <li class="nav-item">
                <a class="dropdown-item" href="<?= base_url('contact-us') ?>">Hubungi Kami</a>
            </li>
        </ul>
    </li>
</ul>
