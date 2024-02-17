<?php

include '../conf/config.php';

$t = time();

if (isset($_POST['tambah-data'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $no_telp = $_POST['no_telp'];
    $jabatan = $_POST['jabatan'];
    $password = $_POST['password'];

    $sql = "CALL buat_pegawai($jabatan, '$nama','$email','$password','$tgl_lahir','$alamat','$no_telp')";

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


if (isset($_POST['edit-data'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $no_telp = $_POST['no_telp'];
    $old_password = $_POST['old_password'];

    $sql = "CALL ubah_pegawai($id, '$nama', '$email', '$old_password', '$tgl_lahir', '$alamat', '$no_telp')";
    if (isset($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "CALL ubah_pegawai($id, '$nama', '$email', '$password', '$tgl_lahir', '$alamat', '$no_telp')";
    } 

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
    $sql = "CALL hapus_pegawai($id)";

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
                        <table id="data-customer" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Tanggal Lahir</th>
                                    <th class="text-center">No. Telp</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "CALL daftar_pegawai";
                                $result = mysqli_query($koneksi, $sql);
                                $row_no = 0;

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $row_no += 1;
                                        $row_id = $row['id_pegawai'];
                                        $row_nama = $row['nama'];
                                        $row_email = $row['email'];
                                        $row_tgl_lahir = $row['tgl_lahir'];
                                        $row_alamat = $row['alamat'];
                                        $row_telepon = $row['telepon'];
                                        $row_jabatan = $row['nama_jabatan']; 
                                        $row_password = $row['password']; 
                                        $row_id_jabatan = $row['id_jabatan']; ?>
                                        <tr>
                                            <td id="no-<?= $row_id ?>" class="text-center align-middle"><?= $row_no ?></td>
                                            <td id="nama-<?= $row_id ?>" class="align-middle"><?= $row_nama ?></td>
                                            <td id="email-<?= $row_id ?>" class="align-middle"><?= $row_email ?></td>
                                            <td id="alamat-<?= $row_id ?>" class=" align-middle"><span><?= $row_alamat ?></span></td>
                                            <td id="tgl-lahir-<?= $row_id ?>" class="text-center align-middle"><?= $row_tgl_lahir ?></td>
                                            <td id="telepon-<?= $row_id ?>" class="text-center align-middle"><?= $row_telepon ?></td>
                                            <td id="jabatan-<?= $row_id ?>" class="text-center align-middle"><span><?= $row_jabatan ?></span></td>
                                            <input id="password-<?= $row_id ?>" type="hidden" value="<?= $row_password ?>">
                                            <input id="id-jabatan-<?= $row_id ?>" type="hidden" value="<?= $row_id_jabatan ?>">
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
                                    $result->close();
                                    $koneksi->next_result();
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
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Masukan Email" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat Anda" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir:</label>
                            <input type="date" class="form-control" name="tgl_lahir">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp:</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="6182xxxxxx" required maxlength="16">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan:</label>
                            <input type="hidden" name="jabatan">
                            <select class="form-control" id="jabatan">
                                <option selected disabled>Pilih jabatan</option>
                                <?php
                                $sql_jabatan = "CALL daftar_jabatan";
                                $result_jabatan = mysqli_query($koneksi, $sql_jabatan);
                                if (mysqli_num_rows($result_jabatan) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_jabatan)) {
                                        $id_jabatan = $row['id_jabatan'];
                                        $jabatan = $row['nama_jabatan'];
                                ?>
                                        <option value="<?= $id_jabatan ?>"><?= $jabatan ?></option>
                                <?php }
                                $result_jabatan->close();
                                $koneksi->next_result();
                                } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
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
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        <input type="hidden" id="edit-old-password" name="old_password">
                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" placeholder="Masukan Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control" id="edit-email" name="email" placeholder="Masukan Email" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea class="form-control" id="edit-alamat" name="alamat" placeholder="Masukan Alamat Anda" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir:</label>
                            <input type="date" class="form-control" name="tgl_lahir" id="edit-tgl-lahir">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp:</label>
                            <input type="text" class="form-control" id="edit-no_telp" name="no_telp" placeholder="62855xxxxxx" required maxlength="16">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan:</label>
                            <input type="hidden" name="jabatan">
                            <select class="form-control" id="edit-jabatan">
                                <option selected disabled>Pilih Jabatan</option>
                                <?php
                                $sql_jabatan = "CALL daftar_jabatan";
                                $result_jabatan = mysqli_query($koneksi, $sql_jabatan);
                                if (mysqli_num_rows($result_jabatan) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_jabatan)) {
                                        $id_jabatan = $row['id_jabatan'];
                                        $jabatan = $row['nama_jabatan'];
                                ?>
                                        <option value="<?= $id_jabatan ?>"><?= $jabatan ?></option>
                                <?php }
                                $result_jabatan->close();
                                $koneksi->next_result();
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="edit-password" name="password" autocomplete="new-password" placeholder="Masukan Password Jika Ingin Ganti">
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
    let table = new DataTable('#data-customer');

    $("#jabatan").on('change', function() {
        $("input[name='jabatan']").val($(this).val());
    })
    $("#edit-jabatan").on('change', function() {
        $("input[name='jabatan']").val($(this).val());
    })

    $(function() {
        $('#data-customer').on('click', '.edit-modal', function() {
            let id = $(this).data("id");

            var nama = $('#nama-' + id).text();
            var email = $('#email-' + id).text();
            var alamat = $('#alamat-' + id).text();
            var tgl_lahir = $('#tgl-lahir-' + id).text();
            var notelp = $('#telepon-' + id).text();
            var jabatan = $('#id-jabatan-' + id).val();
            var old_password = $('#password-' + id).val();

            $('#edit-id').val(id);
            $('#edit-nama').val(nama);
            $('#edit-email').val(email);
            $('#edit-alamat').val(alamat);
            $('#edit-tgl-lahir').val(tgl_lahir);
            $('#edit-no_telp').val(notelp);
            $('#edit-jabatan').val(jabatan);
            $('#edit-old-password').val(old_password);

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