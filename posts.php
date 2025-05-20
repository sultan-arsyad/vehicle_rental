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
                    <form method="POST" action="proses_post.php" enctype="multipart/form-data">
                    <?php
// Misalnya dari database atau input sebelumnya
$harga_per_hari = 100000;
$tgl_rental = date('Y-m-d');
$tgl_kembali = date('Y-m-d', strtotime('+3 days'));
?>
<form action="proses_rental.php" method="POST">
    <!-- Harga per Hari (sembunyikan di input hidden) -->
    <input type="hidden" id="harga_per_hari" value="<?= $harga_per_hari; ?>">

    <!-- Tanggal Rental -->
    <div class="mb-3">
        <label for="tgl_rental" class="form-label">Tanggal Rental</label>
        <input type="date" class="form-control" id="tgl_rental" name="tgl_rental" value="<?= $tgl_rental; ?>" required onchange="hitungTotal()">
    </div>

    <!-- Tanggal Kembali -->
    <div class="mb-3">
        <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
        <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" value="<?= $tgl_kembali; ?>" required onchange="hitungTotal()">
    </div>

    <!-- Total Harga -->
    <div class="mb-3">
        <label for="total" class="form-label">Total Harga</label>
        <input type="text" class="form-control" id="total_harga_display" readonly>
        <!-- Input sebenarnya dikirim ke server -->
        <input type="hidden" name="total_harga" id="total_harga">
    </div>

    <button type="submit" class="btn btn-primary">Sewa Sekarang</button>
</form>

<script>
function hitungTotal() {
    const tglRental = new Date(document.getElementById("tgl_rental").value);
    const tglKembali = new Date(document.getElementById("tgl_kembali").value);
    const hargaPerHari = parseInt(document.getElementById("harga_per_hari").value);

    if (tglRental && tglKembali && tglKembali >= tglRental) {
        const selisihHari = Math.ceil((tglKembali - tglRental) / (1000 * 60 * 60 * 24));
        const total = hargaPerHari * selisihHari;

        document.getElementById("total_harga").value = total;
        document.getElementById("total_harga_display").value = formatRupiah(total);
    } else {
        document.getElementById("total_harga").value = '';
        document.getElementById("total_harga_display").value = '';
    }
}

// Format angka ke format rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Hitung saat halaman pertama kali dimuat
window.onload = hitungTotal;
</script>


                        <!-- Dropdown untuk memilih kategori -->
                        <div class="mb-3">
                            <label for="Kendaraan_id" class="form-label">Kendaraan</label>
                            <select class="form-select" name="kendaraan_id" required>
                                <option value="" selected disabled>Pilih salah satu</option>
             <?php
                                $query = "SELECT * FROM kendaraan"; // Query untuk mengambil data kategori
                                $result = $conn->query($query); // Menjalankan query
                                if ($result->num_rows > 0) { // Jika terdapat data kategori
                                    while ($row = $result->fetch_assoc()) { // Iterasi setiap kategori
                                        echo "<option value='" . $row["kendaraan_id"] . "'>" . $row["model"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <!-- Textarea untuk konten postingan -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea class="form-control" id="content" name="content" required></textarea>
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
// Menyertakan footer halaman
include '.includes/footer.php';
?>