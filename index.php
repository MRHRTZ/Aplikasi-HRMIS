<?php

session_start();

if (isset($_SESSION['id'])) {
    if ($_SESSION['nama_jabatan'] != 'Manager') {
        header('Location: ./employee');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi HRMIS | Masuk</title>
    <link rel="shortcut icon" href="logo.jpg" type="image/jpg">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page" style="background-image: url('assets/img/background.jpg'); background-size: cover;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Login</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masukan informasi akunmu disini!</p>

                <form action="conf/autentikasi.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" checked>
                                <label for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <hr>
                <p class="mb-0 text-center">
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    </script>
</body>
<?php
if (isset($_GET['error'])) {
    $x = $_GET['error'];
    if ($x == 1) {
        echo "
      <script>
      Toast.fire({
        icon: 'error',
        title: 'Username atau password tidak valid'
      })
      </script>";
    } else if ($x == 2) {
        echo "
    <script>
    Toast.fire({
      icon: 'warning',
      title: 'Silahkan Inputkan Username & Password'
    })
    </script>";
    } else if ($x == 3) {
    } else if ($x == 4) {
        echo "
    <script>
    Toast.fire({
      icon: 'warning',
      title: 'Password tidak boleh kurang dari 8 karakter.'
    })
    </script>";
    } else {
        echo '';
    }
}
if (isset($_GET['success'])) {
    $x = $_GET['success'];
    if ($x == 2) {
        echo "
      <script>
      Toast.fire({
        icon: 'success',
        title: 'Register berhasil, silahkan login.'
      })
      </script>";
    }
}
?>

</html>