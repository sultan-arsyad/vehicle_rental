<?php
// Memasukkan header halaman
include '.includes/header.php';
// Menyertakan file untuk menampilkan notifikasi (jika ada)
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Tabel data kategori -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Data Kategori</h4>
            <!-- Tombol untuk menambah kategori baru -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                Tambah Kategori
            </button>
        </div>
<div class="card-body">
<div class="table-responsive text-nowrap">
<table id="datatable" class="table">
<thead>
<tr class="text-center">
<th width="50px">#</th>
<th>TIPE</th>
<th>MODEL</th>
<th>HARGA PER HARI</th>
<th width="150px">Pilihan</th>
</tr>
</thead>

<!-- Mengambil data kategori dari database -->
<tbody class="table-border-bottom-0">
<?php
$index = 1;
$query = "SELECT * FROM kendaraan";
$exec = mysqli_query($conn, $query);

while ($tipe = mysqli_fetch_assoc($exec)): 
?>
    <tr class="text-center">
        <td><?= $index++; ?></td>
        <td><?= $tipe['tipe']; ?></td> 
        <td><?= $tipe['model']; ?></td>
        <td>Rp<?= number_format($tipe['harga_per_hari'], 0, ',', '.'); ?></td>
        <td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                       data-bs-target="#editCategory_<?= $tipe['kendaraan_id']; ?>">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                    </a>
                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                       data-bs-target="#deleteCategory_<?= $tipe['kendaraan_id']; ?>">
                        <i class="bx bx-trash me-2"></i> Delete
                    </a>
                </div>
            </div>
        </td>
    </tr>
    <!-- Modal Add -->
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="proses_kendaraan.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Kendaraan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select class="form-select" name="tipe" required>
              <option value="Motor">Motor</option>
              <option value="Mobil">Mobil</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <select class="form-select" name="model" id="modelSelect" required>
                <option value="" disabled selected>Pilih Model</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="harga_per_hari" class="form-label">Harga per Hari</label>
            <input type="number" class="form-control" name="harga_per_hari" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editCategory_<?= $tipe['kendaraan_id']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="proses_kendaraan.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Kendaraan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="catID" value="<?= $tipe['kendaraan_id']; ?>">

          <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select class="form-select tipe-select" name="tipe" required onchange="updateModelOptionsEdit(this)">
              <option value="Motor" <?= $tipe['tipe'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
              <option value="Mobil" <?= $tipe['tipe'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <select class="form-select model-select" name="model" required>
              <!-- Akan diisi oleh JavaScript -->
              <option value="<?= $tipe['model']; ?>" selected><?= $tipe['model']; ?></option>
            </select>
          </div>

          <div class="mb-3">
            <label for="harga_per_hari" class="form-label">Harga per Hari</label>
            <input type="number" class="form-control" name="harga_per_hari" value="<?= $tipe['harga_per_hari']; ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-warning">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteCategory_<?= $tipe['kendaraan_id']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="proses_kendaraan.php" method="POST">
      <input type="hidden" name="catID" value="<?= $tipe['kendaraan_id']; ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Kendaraan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yakin ingin menghapus kendaraan <strong><?= $tipe['model']; ?></strong>?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>
    
<?php endwhile; ?>
</tbody>
</table>
<?php include '.includes/footer.php'; ?>

<!-- JavaScript untuk dinamis model -->

<script>
  const tipeSelect = document.querySelector('select[name="tipe"]');
  const modelSelect = document.getElementById('modelSelect');

  const modelOptions = {
    Motor: ["Honda Beat", "Yamaha NMAX", "Suzuki Satria"],
    Mobil: ["Toyota Avanza", "Honda Brio", "Mitsubishi Xpander"]
  };

  tipeSelect.addEventListener("change", function () {
    const selectedTipe = this.value;
    const models = modelOptions[selectedTipe] || [];

    // Kosongkan isi dropdown model
    modelSelect.innerHTML = '<option value="" disabled selected>Pilih Model</option>';

    // Tambahkan opsi model sesuai tipe
    models.forEach(function (model) {
      const option = document.createElement("option");
      option.value = model;
      option.textContent = model;
      modelSelect.appendChild(option);
    });
  });
</script>