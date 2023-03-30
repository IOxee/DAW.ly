<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?=base_url('assets/img/logo.png') ?>" >
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li>
                    <a class="btn mx-2 my-3" type="submit" href="#">Why Dawly?</a>
                </li>
                <li>
                    <a class="btn mx-2 my-3" href="#">Products</a>
                </li>
                <li>
                    <a class="btn mx-2 my-3" type="submit">Pricing</a>
                </li>
                <li>
                    <a class="btn mx-2 my-3" type="submit" href="#">Resources</a>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <ul class="navbar-nav">
                <?php if (session()->get('loggedIn')): ?>
                    <li>
                        <a class="btn mx-2 my-3" type="submit" href="<?= base_url('panel') ?>">
                            <i class="bi bi-person"></i>
                            <?= strtoupper(substr(session()->get('name'), 0, 1)) . substr(session()->get('name'), 1)?>
                        </a>
                    </li>
                    <li>
                        <a class="btn mx-2 my-3" type="submit" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i> Tancar sessió
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="btn mx-2 my-3" type="submit" href="<?= base_url('login') ?>">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sessió
                        </a>
                    </li>
                    <li>
                        <a class="btn link-primary mx-2 my-3" type="submit" href="<?= base_url('register') ?>">
                            <i class="bi bi-person-plus"></i> Registrar-se
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-outline-dark mx-2 my-3" type="submit" href="<?= base_url('quote') ?>">Get a Quote</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>