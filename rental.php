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
            <a class="dropdown-item" href="detail_rental.php?rental_id=<?= $rental['rental_id']; ?>">
              <i class="bx bx-show me-1"></i> Detail
            </a>
            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $rental['rental_id']; ?>">
              <i class="bx bx-trash me-1"></i> Hapus
            </button>
          </div>
        </td>
      </tr>

      <!-- Modal Hapus -->
      <div class="modal fade" id="hapusModal<?= $rental['rental_id']; ?>" tabindex="-1" aria-labelledby="hapusLabel<?= $rental['rental_id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" action="hapus_rental.php">
              <div class="modal-header">
                <h5 class="modal-title" id="hapusLabel<?= $rental['rental_id']; ?>">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="rental_id" value="<?= $rental['rental_id']; ?>">
                <p>Yakin ingin menghapus rental oleh <strong><?= htmlspecialchars($rental['nama_pelanggan']); ?></strong> untuk kendaraan <strong><?= $rental['tipe'] . ' ' . $rental['model']; ?></strong>?</p>
              </div>
              <div class="modal-footer">
                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </form>
          </div>
        </div>
      </div>
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
