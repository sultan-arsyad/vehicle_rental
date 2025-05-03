<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan ID pengguna dari sesi
$pelangganId= $_SESSION["pelanggan_id"];

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Ambil data dari form
  $tgl_rental = $_POST['tgl_rental'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $total = str_replace('.', '', $_POST['total']); // Bersihkan format ribuan jika ada

  // Simulasi data login/session
  $pelangganId = 1;      // Ubah sesuai session login
  $kendaraan_id = 1;      // Ubah sesuai input/dropdown kendaraan

  // Simpan ke database
  $query = "INSERT INTO rental (pelanggan_id, kendaraan_id, tgl_rental, tgl_kembali, total)
            VALUES ('$pelangganId', '$kendaraan_id', '$tgl_rental', '$tgl_kembali', '$total')";

  if (mysqli_query($conn, $query)) {
      // Jika berhasil, redirect atau tampilkan notifikasi
      echo "<script>alert('Data rental berhasil disimpan!'); window.location.href='dashboard.php';</script>";
  } else {
      echo "Gagal menyimpan data: " . mysqli_error($conn);
  }
} else {
  echo "Akses tidak sah.";
}

if (isset($_POST['delete'])) {
  // Ambil ID dari form
  $rental_id = $_POST['postID'];

  // Query delete
  $query = "DELETE FROM rental WHERE rental_id = $rental_id";

  if (mysqli_query($conn, $query)) {
      echo "<script>alert('Data berhasil dihapus!'); window.location.href='dashboard.php';</script>";
  } else {
      echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "Akses tidak sah.";
}
if (isset($_POST['update'])) {
  // Ambil data dari form
  $rental_id = $_POST['rental_id'];
  $tgl_rental = $_POST['tgl_rental'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $total_harga = str_replace('.', '', $_POST['total_harga']); // Hilangkan titik pada format rupiah

  // (Opsional) Jika ingin bisa update pelanggan_id atau kendaraan_id juga
  // $pelanggan_id = $_POST['pelanggan_id'];
  // $kendaraan_id = $_POST['kendaraan_id'];

  // Query update
  $query = "UPDATE rental 
            SET tgl_rental = '$tgl_rental', 
                tgl_kembali = '$tgl_kembali', 
                total_harga = '$total_harga'
            WHERE rental_id = '$rental_id'";

  if (mysqli_query($conn, $query)) {
      echo "<script>alert('Data berhasil diupdate!'); window.location.href='dashboard.php';</script>";
  } else {
      echo "Gagal mengupdate data: " . mysqli_error($conn);
  }
} else {
  echo "Akses tidak sah.";
}

//arahkan ke halaman dashboard
header ('Location: dashboard.php');
exit();
