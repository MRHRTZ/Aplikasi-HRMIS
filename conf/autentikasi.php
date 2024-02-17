<?php
include('config.php');

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

if (strlen($password) > 8) {
    header('Location: ../?error=4');
} else {
    $query = mysqli_query($koneksi, "CALL login_pegawai('$username', '$password')");
    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_assoc($query);

        if (isset($row['success'])) {
            $_SESSION['id'] = $row['id_pegawai'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['nama_jabatan'] = $row['nama_jabatan'];
            header('Location: ../admin/');
        } else {
            header('Location: ../?error=1');
        }
    } else if ($username == '' || $password == '') {
        header('Location: ../?error=2');
    } else {
        header('Location: ../?error=1');
    }
}
