<?php
include '.includes/header.php';
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul dan Tombol Tambah -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Daftar Pelanggan</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomer">
                Tambah Data Pelanggan
            </button>
        </div>

        <!-- Tabel Pelanggan -->
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table id="datatable" class="table">
                    <thead class="text-center">
                        <tr>
                            <th width="50px">#</th>
                            <th>Nama Pelanggan</th>
                            <th>NIK</th>
                            <th width="150px">Pilihan</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php
                        $index = 1;
                        $query = "SELECT * FROM pelanggan";
                        $exec = mysqli_query($conn, $query);
                        while ($tipe = mysqli_fetch_assoc($exec)):
                            ?>
                            <tr>
                                <td><?= $index++; ?></td>
                                <td><?= htmlspecialchars($tipe['nama']); ?></td>
                                <td><?= htmlspecialchars($tipe['NIK']); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#editCustomer_<?= $tipe['pelanggan_id']; ?>">
                                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#deleteCustomer_<?= $tipe['pelanggan_id']; ?>">
                                                    <i class="bx bx-trash me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Pelanggan -->
                            <div class="modal fade" id="editCustomer_<?= $tipe['pelanggan_id']; ?>" tabindex="-1"
                                aria-labelledby="editCustomerLabel_<?= $tipe['pelanggan_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <form method="POST" action="proses_pembeli.php" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="editCustomerLabel_<?= $tipe['pelanggan_id']; ?>">Edit Data Pelanggan
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="pelanggan_id"
                                                    value="<?= $tipe['pelanggan_id']; ?>">
                                                <div class="mb-3">
                                                    <label for="nama_<?= $tipe['pelanggan_id']; ?>" class="form-label">Nama
                                                        Pelanggan</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        id="nama_<?= $tipe['pelanggan_id']; ?>"
                                                        value="<?= htmlspecialchars($tipe['nama']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="NIK_<?= $tipe['pelanggan_id']; ?>"
                                                        class="form-label">NIK</label>
                                                    <input type="text" class="form-control" name="NIK"
                                                        id="NIK_<?= $tipe['pelanggan_id']; ?>"
                                                        value="<?= htmlspecialchars($tipe['NIK']); ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="sim_<?= $tipe['pelanggan_id']; ?>" class="form-label">Upload
                                                        Foto SIM (Kosongkan jika tidak ingin diubah)</label>
                                                    <input type="file" class="form-control" name="sim"
                                                        id="sim_<?= $tipe['pelanggan_id']; ?>" accept="image/*">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="edit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Pelanggan -->
                            <div class="modal fade" id="deleteCustomer_<?= $tipe['pelanggan_id']; ?>" tabindex="-1"
                                aria-labelledby="deleteCustomerLabel_<?= $tipe['pelanggan_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="proses_pembeli.php">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="deleteCustomerLabel_<?= $tipe['pelanggan_id']; ?>">Hapus Data
                                                    Pelanggan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="pelanggan_id"
                                                    value="<?= $tipe['pelanggan_id']; ?>">
                                                <p>Apakah Anda yakin ingin menghapus data pelanggan
                                                    <strong><?= htmlspecialchars($tipe['nama']); ?></strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pelanggan -->
    <div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="POST" action="proses_pembeli.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerLabel">Tambah Data Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama" id="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="NIK" class="form-label">NIK</label>
                            <input type="text" class="form-control" name="NIK" id="NIK" required>
                        </div>
                        <div class="mb-3">
                            <label for="sim" class="form-label">Upload Foto SIM</label>
                            <input type="file" class="form-control" name="sim" id="sim" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <?php
    if (isset($_SESSION['notification'])) {
        $notif = $_SESSION['notification'];
        echo '
        <div class="alert alert-' . $notif['type'] . ' alert-dismissible fade show mt-3" role="alert">
            ' . $notif['message'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>';
        unset($_SESSION['notification']);
    }
    ?>
</div>

<?php include '.includes/footer.php'; ?>