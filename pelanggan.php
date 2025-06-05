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
                    <form method="POST" action="proses_pelanggan.php" enctype="multipart/form-data">

                    <!-- Pilih Nama Pelanggan atau Tambah Baru -->
                    <div class="mb-3">
                        <label for="nama_lama" class="form-label">Nama Pelanggan</label>
                        <select class="form-select" name="nama_lama" id="nama_lama" onchange="toggleInputBaru()">
                            <option value="">-- Pilih Nama yang Pernah Memesan --</option>
                            <?php
                            $query = "SELECT DISTINCT nama FROM pelanggan WHERE nama != ''";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['nama']}'>{$row['nama']}</option>";
                            }
                            ?>
                            <option value="__baru__">+ Tambah Nama Baru</option>
                        </select>
                    </div>

                    <!-- Input Nama Baru (disembunyikan dulu) -->
                    <div class="mb-3" id="inputNamaBaru" style="display: none;">
                        <label for="nama_baru" class="form-label">Nama Baru</label>
                        <input type="text" class="form-control" name="nama_baru" id="nama_baru">
                    </div>

                    <script>
                    function toggleInputBaru() {
                        var select = document.getElementById('nama_lama');
                        var inputBaru = document.getElementById('inputNamaBaru');
                        if (select.value === '__baru__') {
                            inputBaru.style.display = 'block';
                            document.getElementById('nama_baru').setAttribute('required', true);
                        } else {
                            inputBaru.style.display = 'none';
                            document.getElementById('nama_baru').removeAttribute('required');
                        }
                    }
                    </script>


                    <!-- Dropdown untuk memilih model kendaraan berdasarkan tipe -->
                    <div class="mb-3">
                        <label for="kendaraan_id" class="form-label">Model Kendaraan</label>
                        <select class="form-select" id="kendaraan_id" name="kendaraan_id" required>
                            <option value="">Pilih Model</option>
                            <?php
                    $query = "SELECT * FROM kendaraan";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tipe = $row['tipe'];
                            $model = $row['model'];
                            $id = $row['kendaraan_id'];
                            $harga = $row['harga_per_hari'];
                            echo "<option value='$id' data-tipe='$tipe' data-harga='$harga'>$model</option>";
                        }
                    }
                    ?>
                        </select>
                    </div>

                    <!-- Tanggal Rental -->
                    <div class="mb-3">
                        <label for="tgl_rental" class="form-label">Tanggal Rental</label>
                        <input type="date" class="form-control" id="tgl_rental" name="tgl_rental" required>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="mb-3">
                        <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali" required>
                    </div>

                    <!-- Total Harga (Otomatis) -->
                    <div class="mb-3">
                        <label for="total" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total" name="total" readonly>
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

                    <script>
                    function filterModel() {
                        var tipe = document.getElementById("tipe").value;
                        var modelSelect = document.getElementById("kendaraan_id");
                        var options = modelSelect.options;

                        for (var i = 0; i < options.length; i++) {
                            var opt = options[i];
                            var dataTipe = opt.getAttribute("data-tipe");

                            if (!dataTipe) continue; // Lewati opsi default
                            if (dataTipe === tipe) {
                                opt.style.display = "block";
                            } else {
                                opt.style.display = "none";
                            }
                        }

                        modelSelect.value = ""; // Reset pilihan
                    }
                    </script>

                    <script>
                    function filterModel() {
                        var tipe = document.getElementById("tipe").value;
                        var modelSelect = document.getElementById("kendaraan_id");
                        var options = modelSelect.options;

                        for (var i = 0; i < options.length; i++) {
                            var opt = options[i];
                            var dataTipe = opt.getAttribute("data-tipe");

                            if (!dataTipe) continue;
                            if (dataTipe === tipe) {
                                opt.style.display = "block";
                            } else {
                                opt.style.display = "none";
                            }
                        }

                        modelSelect.value = ""; // Reset pilihan
                        hitungTotalHarga(); // Reset juga jika ganti tipe
                    }

                    document.getElementById("kendaraan_id").addEventListener("change", hitungTotalHarga);
                    document.getElementById("tgl_rental").addEventListener("change", hitungTotalHarga);
                    document.getElementById("tgl_kembali").addEventListener("change", hitungTotalHarga);

                    function hitungTotalHarga() {
                        var kendaraanSelect = document.getElementById("kendaraan_id");
                        var selectedOption = kendaraanSelect.options[kendaraanSelect.selectedIndex];
                        var hargaPerHari = parseInt(selectedOption.getAttribute("data-harga"));

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
                    </script>
