<?php $this->extend('layout/home') ?>

<?php $this->section('style') ?>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<!-- Redirecting website with description read from database -->
<div class="container mt-5 shadow">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <h3 class="text-center">Redirecting in <span id="counter">5</span> seconds...</h3>
                <p class="text-center"><?= $description ?></p>
            </div>
        </div>
    </div>

<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    var counter = 5;
    setInterval(function() {
        counter--;
        if (counter >= 0) {
            if (counter === 0) {
                window.location.href = "<?= $url ?>";
            }
            span = document.getElementById("counter");
            span.innerHTML = counter;
        }
        if (counter === 0) {
            clearInterval(counter);
        }
    }, 1000);
</script>
<?php $this->endSection() ?>