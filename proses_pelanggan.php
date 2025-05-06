<?php
include 'config.php';
session_start();

$userId = $_SESSION["user_id"];

// PROSES SIMPAN RENTAL BARU
if (isset($_POST['simpan'])) {
    // ... (kode simpan tetap sama)
}

// PROSES UPDATE RENTAL
if (isset($_POST['proses_pelanggan'])) {
    $rental_id = $_POST['rental_id'];
    $pelanggan_id = $_POST['pelanggan_id'];
    $kendaraan_id = $_POST['kendaraan_id'];
    $tgl_rental = $_POST['tgl_rental'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Konversi total tanpa "Rp" dan titik
    $total_clean = preg_replace('/[^\d]/', '', $_POST['total']);

    $updateQuery = "UPDATE rental SET 
                        pelanggan_id = '$pelanggan_id', 
                        kendaraan_id = '$kendaraan_id',
                        tgl_rental = '$tgl_rental',
                        tgl_kembali = '$tgl_kembali',
                        total = '$total_clean'
                    WHERE rental_id = '$rental_id'";

    if (mysqli_query($conn, $updateQuery)) {
        $_SESSION['notification'] = ['type' => 'primary', 'message' => 'Data rental berhasil diperbarui.'];
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal update: ' . mysqli_error($conn)];
    }

    header("Location: rental.php");
    exit();
}

// PROSES HAPUS RENTAL
if (isset($_POST['delete_rental'])) {
    $rental_id = $_POST['rental_id'];

    $deleteQuery = "DELETE FROM rental WHERE rental_id = '$rental_id'";
    if (mysqli_query($conn, $deleteQuery)) {
        $_SESSION['notification'] = ['type' => 'primary', 'message' => 'Data rental berhasil dihapus.'];
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menghapus data rental: ' . mysqli_error($conn)];
    }

    header("Location: rental.php");
    exit();
}
?>
