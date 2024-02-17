<?php

include '../conf/config.php';
include '../conf/function.php';

if (isset($_POST['tambah-data'])) {
  $jabatan = $_POST['jabatan'];

  $sql = "CALL buat_jabatan('$jabatan')";

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

// Kode untuk proses edit data
if (isset($_POST['edit-data'])) {
  $id = $_POST['id'];
  $jabatan = $_POST['jabatan'];

  $sql = "CALL ubah_jabatan($id, '$jabatan')";

  if (mysqli_query($koneksi, $sql)) {
    echo "<script>Toast.fire({
            icon: 'success',
            title: 'Berhasil edit data',
          })</script>";
  } else {
    echo "<script>Swal.fire({
            icon: 'warning',
            title: 'Gagal edit data',
            text: 'Error'" . mysqli_error($koneksi) . "
          })</script>";
  }
}

if (isset($_POST['hapus-data'])) {
  $id = $_POST['id'];
  $sql = "CALL hapus_jabatan($id)";

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
                  <th class="text-center">Jabatan</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "CALL daftar_jabatan";
                $result = mysqli_query($koneksi, $sql);
                $row_no = 0;

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $row_no += 1;
                    $row_id = $row['id_jabatan'];
                    $row_jabatan = $row['nama_jabatan']; ?>
                    <tr>
                      <td class="text-center align-middle"><?= $row_no ?></td>
                      <td id="jabatan-<?= $row_id ?>" class="align-middle"><?= $row_jabatan ?></td>
                      <td class="text-center align-middle">
                        <form action="" method="post">
                          <a href="#editModal" class="btn btn-warning btn-sm edit-modal" data-id="<?= $row_id ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </a>
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
              <label for="jabatan">Nama Jabatan:</label>
              <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukan nama jabatan..." required>
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

  $(function() {
    $('#data-jabatan').on('click', '.edit-modal', function() {
      let id = $(this).data("id");
      var jabatan = $('#jabatan-' + id).text();

      $('#edit-id').val(id);
      $('#edit-jabatan').val(jabatan);
      $('#edit-data').modal('toggle')
    })
  })

  function on_hapus(e) {
    if (confirm("Yakin hapus data ini?")) {
      e.submit();
    } else {
      e.preventDefault();
    }
  }
</script>