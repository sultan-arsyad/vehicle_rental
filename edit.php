<?php
// Memasukkan file konfigurasi database
include 'config.php';

// Memasukkan header halaman
include '.includes/header.php';

// Mengambil ID postingan yang akan diedit dari parameter URL
// .../edit_post.php?post_id=
$postIdToEdit = $_GET['id_rental']; // Pastikan parameter 'post_id' ada di URL

// Query untuk mengambil data postingan berdasarkan ID
$query = "SELECT * FROM rental WHERE rental_id = $postIdToEdit";
$result = $conn->query($query);

// Memeriksa apakah data postingan ditemukan
if ($result->num_rows > 0) {
    $post = $result->fetch_assoc(); // Mengambil data postingan ke dalam array
} else {
    // Menampilkan pesan jika postingan tidak ditemukan
    echo "data not found.";
    exit(); // Menghentikan eksekusi jika tidak ada postingan
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Judul halaman -->
    <div class="row">
        <!-- Form untuk mengedit postingan -->
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Formulir menggunakan metode POST untuk mengirim data -->
                    <form method="POST" action="proses_post.php" enctype="multipart/form-data">
                        <!-- Input tersembunyi untuk menyimpan ID postingan -->
                        <input type="hidden" name="id_rental" value="<?php echo $postIdToEdit; ?>">

                        
                        <?php
// Contoh data yang diambil dari database
$rental_id = $rental['rental_id'];
$tgl_rental = $rental['tgl_rental'];
$tgl_kembali = $rental['tgl_kembali'];
$harga_per_hari = $rental['harga_per_hari']; // Contoh: 100000

// Hitung selisih hari
$date1 = new DateTime($tgl_rental);
$date2 = new DateTime($tgl_kembali);
$jumlah_hari = $date1->diff($date2)->days;

// Hitung total harga
$total= $jumlah_hari * $harga_per_hari;
?>

<!-- Form Edit -->
<form action="edit.php" method="POST">
    <input type="hidden" name="rental_id" value="<?= $rental_id ?>">

    <!-- Tanggal Rental -->
    <div class="mb-3">
        <label for="tgl_rental" class="form-label">Tanggal Rental</label>
        <input type="date" class="form-control" id="tgl_rental" name="tgl_rental"
               value="<?= $tgl_rental ?>" required>
    </div>

    <!-- Tanggal Kembali -->
    <div class="mb-3">
        <label for="tgl_kembali" class="form-label">Tanggal Kembali</label>
        <input type="date" class="form-control" id="tgl_kembali" name="tgl_kembali"
               value="<?= $tgl_kembali ?>" required>
    </div>

    <!-- Total Harga -->
    <div class="mb-3">
        <label for="total" class="form-label">Total Harga</label>
        <input type="text" class="form-control" id="total" name="total"
               value="<?= number_format($total, 0, ',', '.') ?>" readonly>
    </div>

  

                   


                        <!-- Dropdown untuk kategori -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="" selected disabled>Select one</option>
                                <?php
                                // Mengambil data kategori dari database
                                $queryCategories = "SELECT * FROM category";
                                $resultCategories = $conn->query($queryCategories);

                                // Menambahkan opsi ke dropdown
                                if ($resultCategories->num_rows > 0) {
                                    while ($row = $resultCategories->fetch_assoc()) {
                                        // Menandai kategori yang sudah dipilih
                                        $selected = ($row["category_id"] == $post['category_id']) ? "selected" : "";
                                        echo "<option value='". $row["category_id"] . "' $selected>" . $row["category_name"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Textarea untuk konten postingan -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten</label>
                            <textarea class="form-control" id="content" name="content" required><?php echo $post['content']; ?></textarea>
                        </div>

                        <!-- Tombol untuk memperbarui postingan -->
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Memasukkan footer halaman
include '.includes/footer.php';
?>
