<?php $this->extend('layout/home') ?>

<?php $this->section('content') ?>
<div class="container mt-5 shadow">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Sign up and start shortening</h2>
            <p class="text-center">Already have an account? <a href="<?= base_url('login') ?>">Log in</a></p>
            <div class="d-flex justify-content-center">
                <button class="btn btn-outline-secondary me-2" disabled>Sign up with Google</button>
            </div>
            <p class="text-center mt-2">Login with services is currently unavailable.</p>
            <p class="text-center mt-3">OR</p>

            <form action="<?= base_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" autocomplete="username" class="form-control" tabindex="3" autocorrect="off" autocapitalize="none">
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" autocomplete="email" class="form-control" tabindex="3" autocorrect="off" autocapitalize="none">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password <i class="bi bi-info-circle-fill" data-bs-toggle="modal" data-bs-target="#passwordHelperModal"></i></label>
                    <input class="form-control" type="password" name="password" autocomplete="new-password" class="form-control" tabindex="3" autocorrect="off" autocapitalize="none">
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirm">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirm" autocomplete="new-password" class="form-control" tabindex="3" autocorrect="off" autocapitalize="none">
                </div>
                <div class="form-group mb-3">
                    <?php if (isset($captcha)) : ?>
                        <?= $captcha ?>
                    <?php endif ?>
                    <input type="text" class="form-control my-1" id="captcha" name="captcha" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-outline-primary">Sign up</button>
                </div>
            </form>

            <p class="text-center mt-4">By creating an account, you agree to DAWly's <a class="text-decoration-none" href="#">Terms of Service</a>, <a class="text-decoration-none" href="#">Privacy Policy</a> and <a class="text-decoration-none" href="#">Acceptable Use Policy</a>.</p>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passwordHelperModal" tabindex="-1" role="dialog" aria-labelledby="passwordHelperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordHelperModalLabel">Password requirements</h5>
            </div>
            <div class="modal-body">
                <p>The password must meet the following requirements:</p>
                <ul>
                    <li>Must be at least 6 characters.</li>
                    <li>It must contain at least one number.</li>
                    <li>It must contain at least one capital letter and a tiny.</li>
                    <li>It must contain at least a special character, such as <b>!@#$%^&*.</b></li>
                </ul>
                <p>Please choose a safe password to guarantee the safety of your account.</p>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>