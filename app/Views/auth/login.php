<?php $this->extend('layout/home') ?>

<?php $this->section('content') ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success mt-3">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger mt-3">
            <?= session()->getFlashdata('error') ?>        
        </div>
    <?php endif; ?>

    <div class="container mt-5 shadow">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mt-3">Log in and start sharing</h2>
                <p class="text-center">Don't have an account? <a class="text-decoration-none" href="<?= base_url('register') ?>">Sign up</a></p>
                <p class="text-center">Log in with:</p>
                <div class="d-flex justify-content-center">
                    <button href="#" class="btn btn-outline-secondary me-2" disabled><i class="bi bi-google"></i> Google</button>
                    <button href="#" class="btn btn-outline-secondary me-2" disabled><i class="bi bi-twitter"></i> Twitter</button>
                    <button href="#" class="btn btn-outline-secondary me-2" disabled><i class="bi bi-facebook"></i> Facebook</button>
                    <button href="#" class="btn btn-outline-secondary me-2" disabled><i class="bi bi-apple"></i> Apple</button>
                </div>
                <p class="text-center mt-3">Login with services is currently unavailable.</p>
                <p class="text-center mt-4">To log in, enter your email address and password.</p>
                <p class="text-center">To reset your password, click <a class="text-decoration-none" href="<?= base_url('forgot') ?>">"Forgot your password?"</a></p>

                <form action="<?= base_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group mb-3">
                        <label for="email">Email address</label>
                        <input type="email" name="email" id="email" class="form-control"equired>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                    </div>
                </form>
                <p class="text-center mt-4">By signing in with an account, you agree to DAWly's <a class="text-decoration-none" href="#">Terms of Service</a>, <a class="text-decoration-none" href="#">Privacy Policy</a> and <a class="text-decoration-none" href="#">Acceptable Use Policy</a>.</p>
            </div>
        </div>
    </div>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
    <script>
        setTimeout(function() {
            $('.alert').css('z-index', '-1');
            $('.alert').animate({top: '-100px'}, 500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
<?php $this->endSection() ?>