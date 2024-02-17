<?php
include '../conf/config.php';

$queryPegawai = mysqli_query($koneksi, "SELECT * FROM pegawai");
$totalPegawai = mysqli_num_rows($queryPegawai);

$queryJabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
$totalJabatan = mysqli_num_rows($queryJabatan);

$queryCatatan = mysqli_query($koneksi, "SELECT * FROM catatan WHERE waktu_mulai >= CURDATE()");
$totalCatatan = mysqli_num_rows($queryCatatan);
?>

<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-4 col-sm-6 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $totalPegawai ?></h3>

            <p>Data Pegawai</p>
          </div>
          <div class="icon">
            <i class="fas fa-car"></i>
          </div>
          <a href="./?page=pegawai" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-sm-6 col-12">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $totalJabatan ?></h3>

            <p>Data Jabatan</p>
          </div>
          <div class="icon">
            <i class="fas fa-rectangle-list"></i>
          </div>
          <a href="./?page=jabatan" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-4 col-sm-6 col-12">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $totalCatatan ?></h3>

            <p>Catatan Hari ini</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="./?page=dashboard" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="data-jabatan" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Catatan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Waktu Mulai</th>
                    <th class="text-center">Waktu Berakhir</th>
                    <th class="text-center">Lama Pekerjaan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $id_pegawai = $_SESSION['id'];
                  $sql = "CALL daftar_catatan";
                  $result = mysqli_query($koneksi, $sql);
                  $row_no = 0;

                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $row_no += 1;
                      $row_id = $row['id_catatan'];
                      $row_nama = $row['nama_pegawai'];
                      $row_catatan = $row['catatan'];
                      $row_status = $row['status'];
                      $row_waktu_mulai = $row['waktu_mulai'];
                      $row_waktu_berakhir = $row['waktu_berakhir'];
                      $row_lama_pekerjaan = $row['lama_pekerjaan'];
                  ?>
                      <tr>
                        <td class="text-center align-middle"><?= $row_no ?></td>
                        <td class="text-center align-middle"><?= $row_nama ?></td>
                        <td id="catatan-<?= $row_id ?>" class="text-center align-middle"><?= $row_catatan ?></td>
                        <td id="status-<?= $row_id ?>" class="text-center align-middle"><?= $row_status ?></td>
                        <td id="waktu_mulai-<?= $row_id ?>" class="text-center align-middle"><?= $row_waktu_mulai ?></td>
                        <td id="waktu_berakhir-<?= $row_id ?>" class="text-center align-middle"><?= $row_waktu_berakhir ? $row_waktu_berakhir : '-' ?></td>
                        <td id="lama_pekerjaan-<?= $row_id ?>" class="text-center align-middle"><?= $row_lama_pekerjaan ?></td>
                      </tr>
                  <?php
                    }
                  }
                  ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>