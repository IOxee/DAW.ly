<?php $this->extend('layout/home') ?>

<?php $this->section('style') ?>
<style>
    #shortener_section {
        background-color: #0b1736;
        padding: 20px;
    }

    .input-group {
        margin-bottom: 20px;
    }
</style>
<?= $this->endSection() ?>

<?php $this->section('content') ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mt-3">
        <?= session()->getFlashdata('error') ?>        
    </div>
<?php endif; ?>

<section class="section-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="custom_font">We've expanded!
                    Shorten URLs. Generate QR Codes.
                    And now, create Link-in-bios.</h1>
                <a href="<?= base_url('register') ?>" class="btn btn-dark btn-lg">Get Started</a>
            </div>
        </div>
    </div>
</section>

<!-- <section class="container-divider"></section> -->

<section id="shortener_section">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" id="url_inputbox" class="form-control form-control-lg"
                        placeholder="Shorten your link" name="url">
                    <button class="btn btn-primary btn-lg" id="shortener">Shorten</button>
                </div>
                <p class="form-text text-muted">By clicking SHORTEN, you are agreeing to DAWly's <a
                        class="text-secondary" href="https://bitly.com/pages/terms-of-service">Terms of Service</a>,
                    <a class="text-secondary" href="https://bitly.com/pages/privacy">Privacy Policy</a>, and <a
                        class="text-secondary" href="https://bitly.com/pages/acceptable-use">Acceptable Use
                        Policy</a></p>
            </div>
        </div>
    </div>
</section>

<section class="three-columns my-5">
    <div class="cell">
        <div class="block-intro">
            <h3 class="header-m custom_font">DAW.LY Connections Platform</h3>
            <h4>All the products you need to build brand connections, manage links and QR Codes, and connect with
                audiences everywhere, in a single unified platform.</h4>
        </div>
    </div>
    <div class="my-2 container d-flex justify-content-center">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-link"></i> Link Management</h5>
                        <p class="card-text">A comprehensive solution to help make every point of connection between
                            your content and your audience more powerful.</p>
                        <hr>
                        <p><strong>Popular Link Management Features</strong></p>
                        <ul class="fancy-list">
                            <li>URL shortening at scale</li>
                            <li>Custom links with your brand</li>
                            <li>URL redirects</li>
                            <li>Advanced analytics &amp; tracking</li>
                        </ul>
                        <div class="card-buttons">
                            <a id="pricing_clicked_link_management" class="btn btn-dark btn-wide"
                                href="https://bitly.com/pages/pricing">Get Started for Free</a>
                            <a id="product_clicked_link_management" class="btn btn-link"
                                href="https://bitly.com/pages/products/link-management">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-qr-code"></i> QR Codes</h5>
                        <p class="card-text">QR Code solutions for every customer, business and brand experience.</p>
                        <hr>
                        <p><strong>Popular QR Code Features</strong></p>
                        <ul class="fancy-list">
                            <li>Fully customizable QR Codes</li>
                            <li>Dynamic QR Codes</li>
                            <li>QR Code types &amp; destination options</li>
                            <li>Advanced analytics &amp; tracking</li>
                        </ul>
                        <div class="card-buttons">
                            <a id="qrcg_clicked_qr_codes" class="btn btn-dark btn-wide" href="#qr-modal"
                                data-open="qr-modal" aria-controls="qr-modal" aria-haspopup="true" tabindex="0">Get
                                Started for Free</a>
                            <a id="product_clicked_qr_codes" class="btn btn-link"
                                href="https://bitly.com/pages/products/qr-codes">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-person-badge"></i> Link-in-bio <span
                                class="badge bg-secondary">New</span></h1>
                        </h5>
                        <p class="card-text">Bitly Link-in-bio, powered by Bitly Link Management, to help you curate,
                            package and track your best links.</p>
                        <hr>
                        <p><strong>Popular Link-in-bio Features</strong></p>
                        <ul class="fancy-list">
                            <li>Custom URLs for social media</li>
                            <li>Customizable landing page</li>
                            <li>Easy-to-manage links</li>
                            <li>Link and landing page tracking</li>
                        </ul>
                        <div class="card-buttons">
                            <a id="pricing_clicked_link_in_bio" class="btn btn-dark btn-wide"
                                href="https://bitly.com/pages/pricing">Get Started for Free</a>
                            <a id="product_clicked_link_in_bio" class="btn btn-link"
                                href="https://bitly.com/pages/products/link-in-bio">Learn More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<!-- captcha_modal -->
<div class="modal fade" id="captcha_modal" tabindex="-1" aria-labelledby="captchaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="captchaModalLabel">Complete the captcha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action='<?= base_url('short') ?>' method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <?php if (isset($captcha)) : ?>
                                <?= $captcha['captcha'] ?>
                            <?php endif ?>
                        </div>
                        <div class="col-6">
                            <input type="hidden" id="urlToShort" name="url">
                            <div class="mb-3">
                                <label for="captchaInput" class="form-label">Enter the code shown above</label>
                                <input type="text" class="form-control" id="captchaInput" />
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->endSection() ?>


<?php $this->section('scripts') ?>
<script>
    let short_link = "<?= session('short_link') ?>";
    if (short_link) {
        document.getElementById('url_inputbox').value = short_link;
    }

    $('#shortener').click(function () {
        let url = $('#url_inputbox').val();
        $('#urlToShort').val(url);
        $('#captcha_modal').modal('show');
    });

    $('#url_inputbox').mouseover(function () {
        $('#url_inputbox').attr('placeholder', 'Link is valid for 1 month');
    });
    $('#url_inputbox').mouseout(function () {
        $('#url_inputbox').attr('placeholder', 'Shorten your link');
    });
    setTimeout(() => {
        <?php session()->destroy('short_link') ?>
        $('#url_inputbox').val('');
        $('#url_inputbox').attr('placeholder', 'Shorten your link');
    }, 60 * 1000);

    setTimeout(function() {
        $('.alert').css('z-index', '-1');
        $('.alert').animate({top: '-100px'}, 500, function() {
            $(this).remove();
        });
    }, 5000);
</script>
<?php $this->endSection() ?>