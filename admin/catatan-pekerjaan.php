<?php

include '../conf/config.php';
include '../conf/function.php';

if (isset($_POST['tambah-data'])) {
  $id_pegawai = $_SESSION['id'];
  $status = $_POST['status'];
  $catatan = $_POST['catatan'];

  $sql = "CALL buat_catatan_pegawai($id_pegawai, '$catatan', '$status')";

  if (mysqli_query($koneksi, $sql)) {
    echo "<script>Toast.fire({
              icon: 'success',
              title: 'Berhasil tambah data',
            })</script>";
  } else {
    echo "<script>Swal.fire({
              icon: 'warning',
              title: 'Gagal tambah data',
              text: 'Error'" . mysqli_error($koneksi) . "
            })</script>";
  }
}

if (isset($_POST['hapus-data'])) {
  $id = $_POST['id'];
  $sql = "CALL hapus_catatan($id)";

  if (mysqli_query($koneksi, $sql)) {
    echo "<script>Toast.fire({
          icon: 'success',
          title: 'Berhasil hapus data',
        })</script>";
  } else {
    echo "<script>Swal.fire({
          icon: 'warning',
          title: 'Gagal hapus data',
          text: 'Error'" . mysqli_error($koneksi) . "
        })</script>";
  }
}

?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambah-data">+ Tambah Data</button>
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="data-jabatan" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">Catatan</th>
                  <th class="text-center">Status</th>
                  <th class="text-center">Waktu Mulai</th>
                  <th class="text-center">Waktu Berakhir</th>
                  <th class="text-center">Lama Pekerjaan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id_pegawai = $_SESSION['id'];
                $sql = "CALL daftar_catatan_pegawai($id_pegawai)";
                $result = mysqli_query($koneksi, $sql);
                $row_no = 0;

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $row_no += 1;
                    $row_id = $row['id_catatan'];
                    $row_catatan = $row['catatan'];
                    $row_status = $row['status'];
                    $row_waktu_mulai = $row['waktu_mulai'];
                    $row_waktu_berakhir = $row['waktu_berakhir'];
                    $row_lama_pekerjaan = $row['lama_pekerjaan'];
                ?>
                    <tr>
                      <td class="text-center align-middle"><?= $row_no ?></td>
                      <td id="catatan-<?= $row_id ?>" class="text-center align-middle"><?= $row_catatan ?></td>
                      <td id="status-<?= $row_id ?>" class="text-center align-middle"><?= $row_status ?></td>
                      <td id="waktu_mulai-<?= $row_id ?>" class="text-center align-middle"><?= $row_waktu_mulai ?></td>
                      <td id="waktu_berakhir-<?= $row_id ?>" class="text-center align-middle"><?= $row_waktu_berakhir ? $row_waktu_berakhir : '-' ?></td>
                      <td id="lama_pekerjaan-<?= $row_id ?>" class="text-center align-middle"><?= $row_lama_pekerjaan ?></td>
                      <td class="text-center align-middle">
                        <form action="" method="post">
                          <input type="hidden" name="id" value="<?= $row_id ?>">
                          <button type="submit" class="btn btn-danger btn-sm" name="hapus-data" onclick="on_hapus(event)">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </form>
                      </td>
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

  <div class="modal fade" id="tambah-data">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Tambah Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="status">Status:</label>
              <input type="hidden" name="status">
              <select class="form-control" id="status">
                <option selected disabled>Pilih Status</option>'WORKING', 'BREAK', 'STANBY', 'ABSENT'
                <option>WORKING</option>
                <option>BREAK</option>
                <option>STANDBY</option>
                <option>ABSENT</option>
                <option>DONE</option>
              </select>
            </div>
            <div class="form-group">
              <label for="catatan">Catatan:</label>
              <input type="text" class="form-control" id="catatan" name="catatan" placeholder="Masukan catatan..." required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="tambah-data" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="edit-data">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Edit Data</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
              <label for="jabatan">Nama Jabatan:</label>
              <input type="text" class="form-control" id="edit-jabatan" name="jabatan" placeholder="Masukan nama jabatan..." required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="edit-data" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
  let table = new DataTable('#data-jabatan');

  $("#status").on('change', function() {
    $("input[name='status']").val($(this).val());
  })

  function on_hapus(e) {
    if (confirm("Yakin hapus data ini?")) {
      e.submit();
    } else {
      e.preventDefault();
    }
  }
</script>