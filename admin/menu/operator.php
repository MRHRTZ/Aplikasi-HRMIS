<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="./?page=dashboard" class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], 'dashboard')) {
                                                    echo 'active';
                                                  }  ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>
    
    <?php
    if ($_SESSION['nama_jabatan'] != 'Manager') {
    ?>
    <li class="nav-item">
      <a href="./?page=catatan-pekerjaan" class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], 'catatan-pekerjaan')) {
                                                      echo 'active';
                                                    }  ?>">
        <i class="nav-icon fa-solid fa-clipboard"></i>
        <p>Catatan Pekerjaan</p>
      </a>
    </li>
    <?php } else { ?>

    <li class="nav-item">
      <a href="./?page=jabatan" class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], 'jabatan')) {
                                                      echo 'active';
                                                    }  ?>">
        <i class="nav-icon fa-solid fa-suitcase-rolling"></i>
        <p>Jabatan</p>
      </a>
    </li>

    <li class="nav-item">
      <a href="./?page=pegawai" class="nav-link <?php if (str_contains($_SERVER['REQUEST_URI'], 'pegawai')) {
                                                        echo 'active';
                                                      }  ?>">
        <i class="nav-icon fa-solid fa-user-tie"></i>
        <p>Pegawai</p>
      </a>
    </li>

    <?php } ?>

    <li class="nav-item">
      <a href="./logout.php" class="nav-link">
        <i class="nav-icon fas fa-power-off"></i>
        <p>Logout</p>
      </a>
    </li>



</nav>