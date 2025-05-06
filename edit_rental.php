<?php
include 'config.php';
include '.includes/header.php';

// Validasi rental_id dari URL
$rentalId = isset($_GET['rental_id']) ? (int)$_GET['rental_id'] : 0;
if ($rentalId <= 0) {
    echo "ID rental tidak valid.";
    exit;
}

// Ambil data rental
$query = "SELECT rental.*, pelanggan.nama, pelanggan.nomor_lisensi, pelanggan.pelanggan_id, kendaraan.tipe, kendaraan.model 
          FROM rental
          JOIN pelanggan ON rental.pelanggan_id = pelanggan.pelanggan_id
          JOIN kendaraan ON rental.kendaraan_id = kendaraan.kendaraan_id
          WHERE rental.rental_id = $rentalId";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    echo "Data rental tidak ditemukan.";
    exit;
}
$rental = $result->fetch_assoc();
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Edit Data Rental</h4>
    <div class="card">
        <div class="card-body">
            <form method="POST" action="proses_pelanggan.php">
                <input type="hidden" name="rental_id" value="<?= $rental['rental_id'] ?>">
                <input type="hidden" name="pelanggan_id" value="<?= $rental['pelanggan_id'] ?>">

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($rental['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="nomor_lisensi" class="form-label">Nomor Lisensi</label>
                    <input type="text" class="form-control" id="nomor_lisensi" name="nomor_lisensi" value="<?= htmlspecialchars($rental['nomor_lisensi']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe Kendaraan</label>
                    <select class="form-select" id="tipe" name="tipe" onchange="filterModel()" required>
                        <option disabled>Pilih Tipe</option>
                        <option value="Mobil" <?= $rental['tipe'] == 'Mobil' ? 'selected' : '' ?>>Mobil</option>
                        <option value="Motor" <?= $rental['tipe'] == 'Motor' ? 'selected' : '' ?>>Motor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kendaraan_id" class="form-label">Model Kendaraan</label>
                    <select class="form-select" id="kendaraan_id" name="kendaraan_id" required>
                        <option value="">Pilih Model</option>
                        <?php
                        $kendaraanQuery = "SELECT * FROM kendaraan";
                        $kendaraanResult = $conn->query($kendaraanQuery);
                        while ($k = $kendaraanResult->fetch_assoc()) {
                            $selected = $k['kendaraan_id'] == $rental['kendaraan_id'] ? 'selected' : '';
                            echo "<option value='{$k['kendaraan_id']}' data-tipe='{$k['tipe']}' data-harga='{$k['harga_per_hari']}' $selected>{$k['model']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tgl_rental" class="form-label">Tanggal Rental</label>
                    <input type="date" class="form-control" id="tgl_rental" name="tgl_rental" value="<?= $rental['tgl_rental'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="<?= $rental['tgl_kembali'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="total" class="form-label">Total Harga</label>
                    <input type="text" class="form-control" id="total" name="total" value="Rp<?= number_format($rental['total'], 0, ',', '.') ?>" readonly>
                </div>

                <button type="submit" name="proses_pelanggan" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

<?php include '.includes/footer.php'; ?>

<script>
function filterModel() {
    var tipe = document.getElementById("tipe").value;
    var modelSelect = document.getElementById("kendaraan_id");
    var options = modelSelect.options;

    for (var i = 0; i < options.length; i++) {
        var opt = options[i];
        var dataTipe = opt.getAttribute("data-tipe");
        if (!dataTipe) continue;
        opt.style.display = (dataTipe === tipe) ? "block" : "none";
    }

    modelSelect.value = ""; 
    hitungTotalHarga();
}

document.getElementById("kendaraan_id").addEventListener("change", hitungTotalHarga);
document.getElementById("tgl_rental").addEventListener("change", hitungTotalHarga);
document.getElementById("tgl_kembali").addEventListener("change", hitungTotalHarga);

function hitungTotalHarga() {
    var kendaraanSelect = document.getElementById("kendaraan_id");
    var selectedOption = kendaraanSelect.options[kendaraanSelect.selectedIndex];
    var hargaPerHari = parseInt(selectedOption?.getAttribute("data-harga"));
    var tglRental = new Date(document.getElementById("tgl_rental").value);
    var tglKembali = new Date(document.getElementById("tgl_kembali").value);

    if (isNaN(hargaPerHari) || isNaN(tglRental.getTime()) || isNaN(tglKembali.getTime())) {
        document.getElementById("total").value = "";
        return;
    }

    var selisihHari = Math.ceil((tglKembali - tglRental) / (1000 * 60 * 60 * 24));
    if (selisihHari < 1) {
        document.getElementById("total").value = "Tanggal tidak valid";
        return;
    }

    var total = selisihHari * hargaPerHari;
    document.getElementById("total").value = "Rp" + total.toLocaleString('id-ID');
}

window.addEventListener('load', filterModel);
</script>
