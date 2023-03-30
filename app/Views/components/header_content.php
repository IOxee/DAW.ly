<?php $this->extend('layout/home') ?>

<?php $this->section('content') ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Dawly</h1>
                <h2 class="text-center">The best way to manage your business</h2>
                <div class="text-center">
                    <a class="btn btn-outline-dark mx-2 my-3" type="submit" href="<?= base_url('quote') ?>">Get a Quote</a>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection() ?>