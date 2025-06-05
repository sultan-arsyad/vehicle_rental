<?php
include('.includes/header.php');
$title = "Data Rental";
include('.includes/toast_notification.php');
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>Data Rental Kendaraan</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        <table id="datatable" class="table table-hover">
          <thead class="text-center">
            <tr>
              <th>#</th>
              <th>Nama Pelanggan</th>
              <th>Kendaraan</th>
              <th>NIK</th>
              <th>Tanggal Rental</th>
              <th>Tanggal Kembali</th>
              <th>Total (Rp)</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Query dengan INNER JOIN
            $query = "SELECT rental.*, 
                             pelanggan.nama AS nama_pelanggan, 
                             kendaraan.tipe, 
                             kendaraan.model, 
                             pelanggan.NIK
                      FROM rental
                      INNER JOIN pelanggan ON rental.pelanggan_id = pelanggan.pelanggan_id
                      INNER JOIN kendaraan ON rental.kendaraan_id = kendaraan.kendaraan_id";

            $result = mysqli_query($conn, $query);
            if (!$result) {
              echo '<tr><td colspan="8" class="text-center">Query error: ' . mysqli_error($conn) . '</td></tr>';
            } elseif (mysqli_num_rows($result) == 0) {
              echo '<tr><td colspan="8" class="text-center">Tidak ada data rental ditemukan.</td></tr>';
            } else {
              $no = 1;
              while ($rental = mysqli_fetch_assoc($result)) :
            ?>
                <tr class="text-center">
                  <td><?= $no++; ?></td>
                  <td><?= htmlspecialchars($rental['nama_pelanggan']); ?></td>
                  <td><?= htmlspecialchars($rental['tipe'] . ' - ' . $rental['model']); ?></td>
                  <td><?= htmlspecialchars($rental['NIK']); ?></td>
                  <td><?= $rental['tgl_rental']; ?></td>
                  <td><?= $rental['tgl_kembali']; ?></td>
                  <td>Rp <?= number_format($rental['total'], 0, ',', '.'); ?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="edit_rental.php?rental_id=<?= $rental['rental_id']; ?>">
                        <i class="bx bx-edit-alt me-1"></i> Edit
                      </a>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteRental_<?= $rental['rental_id']; ?>">
                        <i class="bx bx-trash me-1"></i> Hapus
                      </a>
                    </div>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="deleteRental_<?= $rental['rental_id']; ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <form action="proses_pelanggan.php" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title">Hapus Data Rental?</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah kamu yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
                              <input type="hidden" name="rental_id" value="<?= $rental['rental_id']; ?>">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" name="delete_rental" class="btn btn-danger">Hapus</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
            <?php
              endwhile;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include('.includes/footer.php'); ?>
