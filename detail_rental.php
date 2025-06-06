<?php
include('.includes/header.php');
include 'config.php';

if (!isset($_GET['rental_id'])) {
  echo "<p>Rental ID tidak ditemukan.</p>";
  exit();
}

$rental_id = $_GET['rental_id'];
$query = "SELECT rental.*, pelanggan.nama, pelanggan.NIK, pelanggan.sim, kendaraan.tipe, kendaraan.model 
          FROM rental 
          JOIN pelanggan ON rental.pelanggan_id = pelanggan.pelanggan_id 
          JOIN kendaraan ON rental.kendaraan_id = kendaraan.kendaraan_id 
          WHERE rental.rental_id = '$rental_id'";

$result = mysqli_query($conn, $query);
if (!$result || mysqli_num_rows($result) == 0) {
  echo "<p>Data tidak ditemukan.</p>";
  exit();
}

$data = mysqli_fetch_assoc($result);
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header">
      <h4>Detail Rental</h4>
    </div>
    <div class="card-body">
      <ul class="list-group">
        <li class="list-group-item"><strong>Nama Pelanggan:</strong> <?= htmlspecialchars($data['nama']); ?></li>
        <li class="list-group-item"><strong>NIK:</strong> <?= htmlspecialchars($data['NIK']); ?></li>
        <li class="list-group-item">
          <strong>Foto SIM:</strong><br>
          <?php
          $simPath = 'uploads/' . $data['sim'];
          if (!empty($data['sim']) && file_exists($simPath)): ?>
            <a href="<?= $simPath; ?>" target="_blank">
              <img src="<?= $simPath; ?>" alt="Foto SIM" class="img-thumbnail mt-2" style="max-width: 300px;">
            </a>
            <p class="text-muted mt-1">Klik gambar untuk memperbesar.</p>
          <?php else: ?>
            <p class="text-muted">Tidak ada foto SIM.</p>
          <?php endif; ?>
        </li>

        <li class="list-group-item"><strong>Kendaraan:</strong> <?= $data['tipe'] . ' - ' . $data['model']; ?></li>
        <li class="list-group-item"><strong>Tanggal Rental:</strong> <?= $data['tgl_rental']; ?></li>
        <li class="list-group-item"><strong>Tanggal Kembali:</strong> <?= $data['tgl_kembali']; ?></li>
        <li class="list-group-item"><strong>Total Harga:</strong> Rp <?= number_format($data['total'], 0, ',', '.'); ?>
        </li>
      </ul>
    </div>
  </div>
</div>


<?php include('.includes/footer.php'); ?>