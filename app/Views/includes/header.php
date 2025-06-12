<header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="d-flex justify-content-start align-items-center">
                <button class="btn d-inline-block d-lg-none" data-toggle="sidenav"><?= svg_icon('menu-2') ?></button>
                <a class="navbar-brand" href="#">Navbar</a>
            </div>

            <div>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="<?= base_url('logout'); ?>">
                            <?= svg_icon('logout'); ?>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>