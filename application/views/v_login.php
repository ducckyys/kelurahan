<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login - Admin Kelurahan</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= base_url('assets/img/icon.ico'); ?>" type="image/x-icon" />
    <script src="<?= base_url('assets/js/plugin/webfont/webfont.min.js'); ?>"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['<?= base_url('assets/admin/css/fonts.min.css'); ?>']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/atlantis.css'); ?>">

    <style>
        .wrapper-login {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            /* Gradien warna modern */
        }

        .container-login {
            max-width: 450px;
            /* Batasi lebar form */
            padding: 2.5rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .container-login h3 {
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .logo-login {
            display: block;
            margin: 0 auto 1.5rem auto;
            max-width: 120px;
            /* Ukuran logo */
            height: auto;
        }
    </style>
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <img src="<?= base_url('assets/img/logo.png'); ?>" alt="Logo Kelurahan" class="logo-login">
            <h3 class="text-center">Login Administrator</h3>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/process'); ?>" method="POST">
                <div class="login-form">
                    <div class="form-group">
                        <label for="username" class="placeholder"><b>Username</b></label>
                        <input id="username" name="username" type="text" class="form-control" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="placeholder"><b>Password</b></label>
                        <div class="position-relative">
                            <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password">
                            <div class="show-password">
                                <i class="icon-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <button type="submit" class="btn btn-primary col-md-12 float-right mt-3 mt-sm-0 fw-bold">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('assets/js/core/jquery.3.2.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/core/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/atlantis.min.js'); ?>"></script>
</body>

</html>