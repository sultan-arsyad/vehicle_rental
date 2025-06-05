<?php
// Menyertakan header halaman
include '.includes/header.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul halaman -->
    <div class="row">
        <!-- Form untuk menambahkan postingan baru -->
<div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="proses_pembeli.php" enctype="multipart/form-data">

                            <!-- Input untuk nama pelanggan -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pelanggan</label>
                                <input type="text" class="form-control" name="nama" id="nama" required>
                            </div>

                            <!-- Input untuk NIK -->
                            <div class="mb-3">
                                <label for="NIK" class="form-label">NIK</label>
                                <input type="text" class="form-control" name="NIK" id="NIK" required>
                            </div>

                            <!-- Upload Foto SIM -->
                            <div class="mb-3">
                                <label for="sim" class="form-label">Upload Foto SIM</label>
                                <input type="file" class="form-control" name="sim" id="sim" accept="image/*" required>
                            </div>

                            <!-- Tombol submit -->
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    include '.includes/footer.php';
                    ?>

                    <?php
                    if (isset($_SESSION['notification'])) {
                        $notif = $_SESSION['notification'];
                        echo '
                        <div class="alert alert-' . $notif['type'] . ' alert-dismissible fade show" role="alert">
                            ' . $notif['message'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        unset($_SESSION['notification']);
                    }
                    ?>