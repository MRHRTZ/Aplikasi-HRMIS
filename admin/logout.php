<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['nama']);
unset($_SESSION['email']);
unset($_SESSION['nama_jabatan']);
header('Location: ../');
?>