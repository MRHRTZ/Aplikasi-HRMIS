<?php
session_start();

if (!isset($_SESSION['id'])) {
  header('Location: ../?error=2');
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include('header.php'); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <?php include('preloader.php'); ?>

    <!-- Navbar -->
    <?php include('navbar.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <?php include('logo.php'); ?>

      <!-- Sidebar -->
      <?php include('sidebar.php'); ?>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <?php include('content_header.php'); ?>
      <!-- /.content-header -->

      <!-- Main content -->
      <?php
      if (isset($_GET['page'])) {
        if ($_GET['page'] == 'dashboard') {
          include('dashboard.php');
        } else if ($_GET['page'] == 'jabatan') {
          include('jabatan.php');
        } else if ($_GET['page'] == 'pegawai') {
          include('pegawai.php');
        } else if ($_GET['page'] == 'catatan-pekerjaan') {
          include('catatan-pekerjaan.php');
        } else {
          include('dashboard.php');
        }
      } else {
        include('dasboard.php');
        echo '<script>window.location.href=window.location.href+"?page=dashboard"</script>';
      } ?>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include('footer.php'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

</body>

</html>