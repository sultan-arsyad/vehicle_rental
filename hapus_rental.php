<?php
session_start();
include 'config.php';

if (isset($_POST['hapus'])) {
    $rental_id = $_POST['rental_id'];

    $check = mysqli_query($conn, "SELECT * FROM rental WHERE rental_id = '$rental_id'");
    if (mysqli_num_rows($check) > 0) {
        $delete = mysqli_query($conn, "DELETE FROM rental WHERE rental_id = '$rental_id'");
        $_SESSION['notification'] = [
            'type' => $delete ? 'success' : 'danger',
            'message' => $delete ? 'Data rental berhasil dihapus.' : 'Gagal menghapus data rental.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'warning',
            'message' => 'Data rental tidak ditemukan.'
        ];
    }
}

header('Location: rental.php'); // ganti sesuai nama file list rental
exit;
