<?php
// Menghubungkan ke file konfigurasi database
include("config.php");

// Memulai sesi untuk menyimpan notifikasi
session_start();

// Proses penambahan kategori baru
if (isset($_POST['simpan'])) {
    // Mengambil data nama kategori dari form
    $model = $_POST['model'];

    // Query untuk menambahkan data kategori ke dalam database
    $query = "INSERT INTO kendaraan(model) VALUES ('$model')";
    $exec = mysqli_query($conn, $query);

    // Menyimpan notifikasi berhasil atau gagal ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary', // Jenis notifikasi (contoh: primary untuk keberhasilan)
            'message' => 'MODEL berhasil ditambahkan SLURR!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger', // Jenis notifikasi (contoh: danger untuk kegagalan)
            'message' => 'Gagal menambahkan Model jing: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman kategori
    header('Location: kategori.php');
    exit();
}

// Proses penghapusan kategori
if (isset($_POST['delete'])) {

  // Mengambil ID kategori dari parameter URL
  $catID = $_POST['catID'];

  // Query untuk menghapus kategori berdasarkan ID
  $exec = mysqli_query($conn, "DELETE FROM kendaraan WHERE kendaraan_id='$catID'");

  // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
  if ($exec) {
    $_SESSION['notification'] = [
      'type' => 'primary',
      'message' => ' berhasil dihapus!'
    ];
  } else {
    $_SESSION['notification'] = [
      'type' => 'danger',
      'message' => 'Gagal menghapus: ' . mysqli_error($conn)
    ];
  }

  // Redirect kembali ke halaman kategori
  header('Location: kategori.php');
  exit();
}
// Proses pembaruan kategori
if (isset($_POST['update'])) {
    // Mengambil data dari form pembaruan
    $catID = $_POST['catID'];
    $model = $_POST['model'];

    // Query untuk memperbarui data kategori berdasarkan ID
    $query = "UPDATE kendaraan SET model = '$model' WHERE kendaraan_id='$catID'";
    $exec = mysqli_query($conn, $query);

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => ' berhasil diperbarui!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman kategori
    header('Location: kategori.php');
    exit();
}
?>




