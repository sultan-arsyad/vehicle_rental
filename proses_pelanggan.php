<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan ID pengguna dari sesi
$userId = $_SESSION["user_id"];

// Menangani form untuk menambahkan postingan baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $nama = $_POST["nama"]; // Judul postingan
    $nomorlisensi = $_POST["nomor_lisensi"]; // Konten postingan

        // data postingan ke dalam database
        $query = "INSERT INTO pelanggan (nama, nomor_lisensi) VALUES ('$nama', '$nomorlisensi')";
        if ($conn->query($query) === TRUE) {
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post succesfully added.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    header('Location: rental.php');
    exit();

// Proses penghapusan postingan

    if (isset($_POST['delete'])) {

        // Mengambil ID post dari parameter URL

        $pelangganID = $_POST['pelanggan_id'];

        // Query untuk menghapus post berdasarkan ID
        $exec = mysqli_query($conn, "DELETE FROM pelanggan WHERE pelanggan_id = '$pelangganID'");

        // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
        if ($exec) {
            $_SESSION['notification'] = [
                'message' => 'Post successfully deleted.',
                'type' => 'primary',
            ];
        } else {
            $_SESSION['notification'] = [
                'message' => 'Error deleting post: ' . mysqli_error($conn),
                'type' => 'danger',
            ];
        }

        // Redirect kembali ke halaman dashboard
        header('Location: rental.php');
        exit();
    }
// Mengangani pembaruan data postingan
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
  // Mendapatkan data dari form
  $pelangganID = $_POST['pelanggan_id'];
  $nama = $_POST['nama'];
  $nomorlisensi = $_POST['nomor_lisensi'];

  // Update data postingan di database
  $queryUpdate = "UPDATE pelanggan SET nama = '$nama', nomor_lisensi = '$nomorlisensi' WHERE pelanggan_id = '$pelangganID'";
  $conn->query($queryUpdate);

  if ($conn->query($queryUpdate) === TRUE) {
    // Session notifikasi
    $_SESSION['notification'] = [
      'type' => 'primary',
      'message' => 'Postingkan berhasil diperbarui.'
    ];
  } else {
    // Session notifikasi gagal
  $_SESSION['notification'] = [
    'type' => 'danger',
    'massage' => 'gagal memperbarui postingan.'
  ];
}
//arahkan ke halaman dashboard
header ('Location: rental.php');
exit();
}