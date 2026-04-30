<!DOCTYPE html>
<html dir="ltr" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/logo-lixicon.png') ?>">
    <title><?= $title ?></title>
    <link href="<?= base_url('assets/css/style.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icons/font-awesome/css/fontawesome-all.min.css') ?>" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #0f172a;
            --brand-navy: #1e3a5f;
            --brand-blue: #2563eb;
            --brand-blue-light: #3b82f6;
            --brand-accent: #60a5fa;
            --text-muted-custom: #64748b;
            --border-color: #e2e8f0;
            --input-focus: #2563eb;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background: #f8fafc;
            display: flex;
            align-items: stretch;
            min-height: 100vh;
        }

        .login-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* ---- LEFT PANEL ---- */
        .login-brand-panel {
            flex: 0 0 45%;
            background: linear-gradient(145deg, var(--brand-dark) 0%, var(--brand-navy) 60%, #1d4ed8 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            position: relative;
            overflow: hidden;
        }

        .brand-inner {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 340px;
        }

        .brand-logo {
            width: 140px;
            height: auto;
            margin-bottom: 32px;
            opacity: 0.95;
        }

        .brand-title {
            color: #ffffff;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 14px;
            width: 100%;
        }

        .brand-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 12px 16px;
            text-align: left;
        }

        .brand-feature-item .fi-icon {
            width: 36px;
            height: 36px;
            background: rgba(96, 165, 250, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-accent);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .brand-feature-item span {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
            font-weight: 500;
        }

        /* ---- RIGHT PANEL ---- */
        .login-form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
            background: #ffffff;
        }

        .login-form-box {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            margin-bottom: 25px;
        }

        .form-header .company-tag {
            display: inline-block;
            background: #eff6ff;
            color: var(--brand-blue);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 16px;
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 8px;
            letter-spacing: -0.02em;
        }

        .form-header p {
            color: var(--text-muted-custom);
            font-size: 0.875rem;
            margin: 0;
            line-height: 1.5;
        }

        /* Form controls */
        .form-group-modern {
            margin-bottom: 20px;
        }

        .form-group-modern label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            pointer-events: none;
        }

        .input-wrapper .form-control {
            padding-left: 40px;
            padding-right: 14px;
            height: 46px;
            border: 1.5px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.875rem;
            color: #0f172a;
            background: #f8fafc;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .input-wrapper .form-control:focus {
            border-color: var(--input-focus);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
            outline: none;
        }

        .input-wrapper .form-control::placeholder {
            color: #b0bec5;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            font-size: 0.85rem;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
            transition: color 0.15s;
        }

        .password-toggle:hover {
            color: var(--brand-blue);
        }

        .input-wrapper.has-toggle .form-control {
            padding-right: 42px;
        }

        .form-error-text {
            color: #dc2626;
            font-size: 0.75rem;
            margin-top: 4px;
            display: block;
        }

        /* Submit button */
        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--brand-blue) 0%, #1d4ed8 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .login-footer {
            margin-top: 28px;
            text-align: center;
        }

        .login-footer p {
            color: var(--text-muted-custom);
            font-size: 0.8rem;
            margin: 0;
            line-height: 1.6;
        }

        .login-footer .contact-link {
            color: var(--brand-blue);
            font-weight: 600;
            white-space: nowrap;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border-color);
            margin: 28px 0;
        }

        /* Preloader */
        .preloader {
            position: fixed;
            inset: 0;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: hidePreloader 0s ease-in 3s forwards;
        }

        @keyframes hidePreloader {
            to {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
        }

        .lds-ripple {
            position: relative;
            width: 64px;
            height: 64px;
        }

        .lds-pos {
            position: absolute;
            border: 4px solid var(--brand-blue);
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        .lds-pos:nth-child(2) {
            animation-delay: -0.5s;
        }

        @keyframes lds-ripple {
            0% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 1;
            }

            100% {
                top: -1px;
                left: -1px;
                width: 58px;
                height: 58px;
                opacity: 0;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-brand-panel {
                display: none;
            }

            .login-form-panel {
                padding: 32px 24px;
            }

            body {
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .login-form-panel {
                padding: 24px 16px;
            }

            .form-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div class="login-wrapper">

        <!-- Left brand panel -->
        <div class="login-brand-panel">
            <div class="brand-inner">
                <img src="<?= base_url('assets/images/logo-lixicon.png') ?>" alt="Lixicon" class="brand-logo">
                <div class="brand-title">Warehouse Management System</div>
                <p class="brand-subtitle">Platform terintegrasi untuk monitoring stok, transfer gudang, dan manajemen
                    pengadaan barang.</p>
                <!-- <div class="brand-features">
                    <div class="brand-feature-item">
                        <div class="fi-icon"><i class="fas fa-boxes"></i></div>
                        <span>Manajemen Stok Multi-Gudang</span>
                    </div>
                    <div class="brand-feature-item">
                        <div class="fi-icon"><i class="fas fa-exchange-alt"></i></div>
                        <span>Transfer & Pelacakan Barang</span>
                    </div>
                    <div class="brand-feature-item">
                        <div class="fi-icon"><i class="fas fa-file-invoice"></i></div>
                        <span>Purchase Request & Order</span>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Right form panel -->
        <div class="login-form-panel">
            <div class="login-form-box">

                <div class="form-header">
                    <!-- <span class="company-tag">PT. Lixicon Indonesia</span> -->
                    <h1>Selamat Datang</h1>
                    <p>Masukan alamat email dan password untuk mengakses panel utama</p>
                </div>

                <div class="row">
                    <div class="col-12">
                        <?php $this->load->view('layouts/_alert') ?>
                    </div>
                </div>

                <form action="<?= base_url('login') ?>" method="POST">
                    <div class="form-group-modern">
                        <label for="input-email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <?= form_input([
                                'type' => 'email',
                                'id' => 'input-email',
                                'name' => 'email',
                                'class' => 'form-control',
                                'placeholder' => 'Masukan email anda',
                                'required' => true,
                                'autofocus' => true,
                            ]) ?>
                        </div>
                        <span class="form-error-text"><?= form_error('email') ?></span>
                    </div>

                    <div class="form-group-modern">
                        <label for="input-password">Password</label>
                        <div class="input-wrapper has-toggle">
                            <i class="fas fa-lock input-icon"></i>
                            <?= form_password('password', '', [
                                'id' => 'input-password',
                                'class' => 'form-control',
                                'placeholder' => 'Masukkan password',
                                'required' => true,
                            ]) ?>
                            <button type="button" class="password-toggle" id="toggle-password" tabindex="-1"
                                aria-label="Toggle password visibility">
                                <i class="fas fa-eye" id="toggle-password-icon"></i>
                            </button>
                        </div>
                        <span class="form-error-text"><?= form_error('password') ?></span>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </button>
                </form>

                <hr class="divider">

                <div class="login-footer">
                    <p>Lupa email/password? Silahkan hubungi admin.</p>
                    <p><span class="contact-link">085267865288</span></p>
                </div>

            </div>
        </div>

    </div>

    <script src="<?= base_url('assets/libs/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/popper.js/umd/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/libs/bootstrap/js/bootstrap.min.js') ?>"></script>
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

            // Password toggle
            $('#toggle-password').on('click', function () {
                var field = $('#input-password');
                var icon = $('#toggle-password-icon');
                if (field.attr('type') === 'password') {
                    field.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    field.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });

        setTimeout(function () { $(".preloader").fadeOut(); }, 2000);
    </script>
</body>

</html>