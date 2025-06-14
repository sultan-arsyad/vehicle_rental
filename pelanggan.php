<?php include '.includes/header.php'; ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="proses_pelanggan.php" enctype="multipart/form-data">

                        <!-- Pilih Pelanggan -->
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pilih Pelanggan</label>
                            <select class="form-select" name="pelanggan_id" id="pelanggan_id" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php
                                $pelangganResult = $conn->query("SELECT pelanggan_id, nama, NIK FROM pelanggan");
                                while ($row = $pelangganResult->fetch_assoc()) {
                                    echo "<option value='{$row['pelanggan_id']}'>{$row['nama']} ({$row['NIK']})</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <!-- Pilih Tipe Kendaraan -->
                        <div class="mb-3">
                            <label for="tipe_kendaraan" class="form-label">Tipe Kendaraan</label>
                            <select class="form-select" id="tipe_kendaraan" name="tipe_kendaraan" required>
                                <option value="">Pilih Tipe</option>
                                <?php
                                $queryTipe = "SELECT DISTINCT tipe FROM kendaraan";
                                $resultTipe = $conn->query($queryTipe);
                                while ($row = $resultTipe->fetch_assoc()) {
                                    $tipe = $row['tipe'];
                                    echo "<option value='$tipe'>$tipe</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Pilih Model Kendaraan -->
                        <div class="mb-3">
                            <label for="kendaraan_id" class="form-label">Model Kendaraan</label>
                            <select class="form-select" id="kendaraan_id" name="kendaraan_id" required>
                                <option value="">Pilih Model</option>
                                <?php
                                $queryModel = "SELECT * FROM kendaraan";
                                $resultModel = $conn->query($queryModel);
                                while ($row = $resultModel->fetch_assoc()) {
                                    $model = $row['model'];
                                    $id = $row['kendaraan_id'];
                                    $harga = $row['harga_per_hari'];
                                    $tipe = $row['tipe']; // penting!
                                    echo "<option value='$id' data-harga='$harga' data-tipe='$tipe'>$model</option>";
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

                        <!-- Total Harga -->
                        <div class="mb-3">
                            <label for="total" class="form-label">Total Harga</label>
                            <input type="text" class="form-control" id="total" readonly>
                            <input type="hidden" name="total" id="total_raw">
                        </div>

                        <!-- Tombol Simpan -->
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '.includes/footer.php'; ?>

<!-- Script untuk tipe dan model -->
<script>
    document.getElementById('tipe_kendaraan').addEventListener('change', function () {
        const tipeDipilih = this.value;
        const modelDropdown = document.getElementById('kendaraan_id');
        const options = modelDropdown.querySelectorAll('option');

        options.forEach(function (option) {
            const tipeOption = option.getAttribute('data-tipe');

            if (!tipeOption) return; // skip <option>Pilih Model</option>

            if (tipeDipilih === "" || tipeOption === tipeDipilih) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });

        modelDropdown.value = ""; // reset pilihan model
    });
</script>


<!-- Script Hitung Total Harga -->
<script>
    const kendaraanSelect = document.getElementById("kendaraan_id");
    const tglRentalInput = document.getElementById("tgl_rental");
    const tglKembaliInput = document.getElementById("tgl_kembali");

    kendaraanSelect.addEventListener("change", hitungTotalHarga);
    tglRentalInput.addEventListener("change", hitungTotalHarga);
    tglKembaliInput.addEventListener("change", hitungTotalHarga);

    function hitungTotalHarga() {
        const selectedOption = kendaraanSelect.options[kendaraanSelect.selectedIndex];
        const hargaPerHari = parseInt(selectedOption.getAttribute("data-harga"));

        const tglRental = new Date(tglRentalInput.value);
        const tglKembali = new Date(tglKembaliInput.value);

        if (isNaN(hargaPerHari) || isNaN(tglRental.getTime()) || isNaN(tglKembali.getTime())) {
            document.getElementById("total").value = "";
            document.getElementById("total_raw").value = "";
            return;
        }

        const selisihHari = Math.ceil((tglKembali - tglRental) / (1000 * 60 * 60 * 24));

        if (selisihHari < 1) {
            document.getElementById("total").value = "Tanggal tidak valid";
            document.getElementById("total_raw").value = "";
            return;
        }

        const total = selisihHari * hargaPerHari;
        document.getElementById("total").value = "Rp" + total.toLocaleString("id-ID");
        document.getElementById("total_raw").value = total;
    }
</script>