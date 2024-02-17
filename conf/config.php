<?php

date_default_timezone_set('Asia/Jakarta');
$format_db_date = "%T %d/%m/%Y";

$upload_dir = "uploads/";
$host = "localhost";
$user = "root";
$pass = "";
$db = "app_hrmis";

$koneksi = mysqli_connect($host, $user,'', $db);
if(!$koneksi){
    die("Koneksi Gagal:". mysqli_connect_error());
}
?>