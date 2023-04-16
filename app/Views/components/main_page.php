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
                <form action="<?= base_url('short') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group">
                        <input type="text" id="url_inputbox" class="form-control form-control-lg" placeholder="Shorten your link" name="url">
                        <button class="btn btn-primary btn-lg" type="submit">Shorten</button>
                    </div>
                    <p class="form-text text-muted">By clicking SHORTEN, you are agreeing to DAWly's <a class="text-secondary" href="https://bitly.com/pages/terms-of-service">Terms of Service</a>, <a class="text-secondary" href="https://bitly.com/pages/privacy">Privacy Policy</a>, and <a class="text-secondary" href="https://bitly.com/pages/acceptable-use">Acceptable Use Policy</a></p>
                </form>
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

<?php $this->endSection() ?>


<?php $this->section('scripts') ?>
<script>
    let short_link = "<?= session('short_link') ?>";
    if (short_link) {
        document.getElementById('url_inputbox').value = short_link;
    }

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
</script>
<?php $this->endSection() ?>