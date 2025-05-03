<?php
include (".includes/header.php");
$title = "Dashboard";
// Menyertakan file untuk menampilkan notifikasi (jika ada)
include ".includes/toast_notification.php";
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Card untuk menampilkan tabel postingan -->
    <div class="card">
        <!-- Tabel dengan baris yang dapat di-hover -->
        <div class="card">
            <!-- Header Tabel -->
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>DATA PENYEWAAN</h4>
            </div>

            <div class="card-body">
                <!-- Tabel responsif -->
                <div class="table-responsive text-nowrap">
                    <table id="datatable" class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th width="50px">#</th>
                                <th>Tanggal Rental</th>
                                <th>Nama User</th>
                                <th>Tipe</th>
                                <th>Tanggal Kembali</th>
                                <th>Total Harga</th>
                                <th width="150px">Pilihan</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <!-- Menampilkan data dari tabel database -->
                            <?php
                            $index = 1; // Variabel untuk nomor urut
                            // Query untuk mengambil data dari tabel posts, users, dan category
                            $query = "SELECT rental.*, kendaraan.tipe ,pelanggan.nama_user 
                                      FROM rental 
                                      INNER JOIN  pelanggan ON rental.pelanggan_id = pelanggan.pelanggan_id 
                                      LEFT JOIN  kendaraan ON rental.kendaraan_id = kendaraan.kendaraan_id 
                                      WHERE rental.pelanggan_id = $pelangganId";

                            // Eksekusi query
                            $exec = mysqli_query($conn, $query);

                            // Perulangan untuk menampilkan setiap baris hasil query
                            while ($post = mysqli_fetch_assoc($exec)) :
                            ?>
                                <tr>
                                    <td><?= $index++; ?></td>
                                    <td><?= $post['tgl_rental']; ?></td>
                                    <td><?= $post['nama_user']; ?></td>
                                    <td><?= $post['tipe']; ?></td>
                                    <td><?= $post['tgl_kembali']; ?></td>
                                    <td><?= $post['Total']; ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <!-- Tombol dropdown untuk Pilihan -->
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <!-- Pilihan Edit -->
                                                <a href="edit_post.php?post_id=<?= $post['rental_id']; ?>" class="dropdown-item">
                                                    <i class="bx bx-edit-alt me-2"></i> Edit
                                                </a>
                                                <!-- Pilihan Delete -->
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deletePost_<?= $post['rental_id']; ?>">
                                                    <i class="bx bx-trash me-2"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal untuk Hapus Konten Blog -->
                     <div class="modal fade" id="deletePost_<?= $post['rental_id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus data?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="proses_post.php" method="POST">
                                                    <p>Tindakan ini tidak bisa dibatalkan.</p>
                                                    <input type="hidden" name="postID" value="<?= $post['rental_id']; ?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
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
</div>

<?php include (".includes/footer.php"); ?>
