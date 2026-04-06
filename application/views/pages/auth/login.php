<!DOCTYPE html>
<html dir="ltr">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/Logo-1.png') ?>">
    <title><?= $title ?></title>
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/style.min.css') ?>" rel="stylesheet">
    <!-- Preloader auto-hide fallback -->
    <style>
        .preloader {
            animation: hidePreloader 0s ease-in 3s forwards;
        }

        @keyframes hidePreloader {
            to {
                opacity: 0;
                visibility: hidden;
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url(<?= base_url('assets/images/big/auth-bg.jpg') ?>) no-repeat center center;">
            <div class="auth-box row">
                <div class="col-lg-7 col-md-5 modal-bg-img"
                    style="background-image: url(<?= base_url('assets/images/auth/login.jpg') ?>);">
                </div>
                <div class="col-lg-5 col-md-7 bg-white">
                    <div class="p-3">
                        <h2 class="mt-3 text-center">Login</h2>
                        <p class="text-center">Masukan alamat email dan password untuk mengakses panel utama</p>
                        <br>
                        <center>
                            <p>REPOST BY PT.LIXICON INDONESIA</p>
                        </center>

                        <div class="row">
                            <div class="col-lg-12">
                                <?php $this->load->view('layouts/_alert') ?>
                            </div>
                        </div>
                        <form action="<?= base_url('login') ?>" class="mt-2" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="">Email</label>
                                        <?= form_input(['type' => 'email', 'name' => 'email', 'class' => 'form-control', 'placeholder' => 'Masukan email anda', 'required' => true, 'autofocus' => true]) ?>
                                        <?= form_error('email') ?>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="">Password</label>
                                        <?= form_password('password', '', ['class' => 'form-control', 'placeholder' => 'Masukkan password', 'required' => true]) ?>
                                        <?= form_error('password') ?>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <button type="submit" class="btn btn-block btn-dark">Login</button>
                                </div>
                                <div class="col-lg-12 text-center mt-5">
                                    Lupa email/password? <p> Silahkan hubungi admin. 085267865288</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->

    <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('assets/libs/popper.js/umd/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.min.js') ?>"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>

        $(document).ready(function () {
            $(".preloader").fadeOut();

            // Auto-inject CSRF token into all forms
            var csrfName = '<?= $this->security->get_csrf_token_name() ?>';
            var csrfHash = '<?= $this->security->get_csrf_hash() ?>';
            $('form').each(function () {
                if ($(this).find('input[name="' + csrfName + '"]').length === 0) {
                    $(this).append('<input type="hidden" name="' + csrfName + '" value="' + csrfHash + '">');
                }
            });
        });
        // Fallback: hide preloader after 2 seconds
        setTimeout(function () {
            $(".preloader").fadeOut();
        }, 2000);
    </script>
</body>

</html>