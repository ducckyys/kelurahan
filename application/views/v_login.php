<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login - Admin Kelurahan</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="<?= base_url('assets/img/icon.ico'); ?>" type="image/x-icon" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/login_custom.css'); ?>">
</head>

<body class="login">
    <div class="container-login">
        <h3>Login Administrator</h3>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert-danger" role="alert">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/process'); ?>" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" class="form-control" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password">
            </div>
            <div class="form-action">
                <button type="submit" class="btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>

</html>