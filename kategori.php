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
            <h4>Data Kendaraan</h4>
            <!-- Tombol untuk menambah kategori baru -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory">
                Tambah Data Kendaraan
            </button>
        </div>
<div class="card-body">
<div class="table-responsive text-nowrap">
<table id="datatable" class="table table-hover">
<thead>
<tr class="text-center">
<th width="50px">#</th>
<th>Model Kendaraan Anda</th>
<th width="150px">Pilihan</th>
</tr>
</thead>
<tbody class="table-border-bottom-0">


<!-- Mengambil data kategori dari database -->
<?php
$index = 1;
$query = "SELECT * FROM kendaraan";
$exec = mysqli_query($conn, $query); // Pastikan $conn sudah didefinisikan (koneksi database)

while ($kendaraan = mysqli_fetch_assoc($exec)): 
?>

<!-- Dropdown untuk memilih tipe kendaraan -->
<div class="mb-3">
    <label for="tipe" class="form-label">Tipe Kendaraan</label>
    <select class="form-select" id="tipe" name="tipe" onchange="filterModel()" required>
        <option value="" selected disabled>Pilih Tipe</option>
        <option value="Mobil">Mobil</option>
        <option value="Motor">Motor</option>
    </select>
</div>

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
                echo "<option value='$id' data-tipe='$tipe'>$model</option>";
            }
        }
        ?>
    </select>
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
    <tr>
        <!-- menampilkan nomor kategori, dan opsi -->
        <td><?= $index++; ?></td>
         <td><?= $kendaraan['model']; ?></td> 

         <td>
            <!-- dropdown untuk opsi edit dan delete -->
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                 </button>
                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                     data-bs-target="#editCategory_<?= $kendaraan['kendaraan_id']; ?>">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                    </a>
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deletekendaraan_<?= $kendaraan['kendaraan_id']; ?>">
                        <i class="bx bx-trash me-2"></i> Delete</a>
                </div>
            </div>
        </td>

    </tr>
<!-- modal untuk hapus data kategori -->
<div class="modal fade" id="deletekendaraan_<?= $kendaraan['kendaraan_id']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus model kendaraan?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="proses_kategori.php" method="POST">
                    <div>
                        <p>Tindakan ini tidak bisa dibatalkan.</p>
                        <input type="hidden" name="catID" value="<?= $kendaraan['kendaraan_id']; ?>">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
            </div>
                </form>
        </div>
    </div>
</div>
 <!-- modal untuk update kategory -->
 <div id="editkendaraan_<?= $kendaraan['kendaraan_id']; ?>" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update model kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="proses_kategori.php" method="POST">
                    <input type="hidden" name="catID" value="<?= $kendaraan['kendaraan_id']; ?>">
                    <div class="form-group">
                        <label>Model kendaraan</label>
                        <input type="text" value="<?= $kendaraan['model']; ?>" name="model" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>    
</div>

<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php include '.includes/footer.php'; ?>

<!--modal untuk tambah data kategory --> 
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="proses_kategori.php" method="POST">
                    <div class="mb-3">
                        <label for="namakendaraan" class="form-label">Model Kendaraan</label>
                        <input type="text" class="form-control" name="model" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>