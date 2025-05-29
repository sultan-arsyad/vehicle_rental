<?php
// Menghubungkan ke konfigurasi database
include("config.php");

// Mulai sesi untuk notifikasi
session_start();

// Tambah data kendaraan
if (isset($_POST['simpan'])) {
    $tipe = $_POST['tipe'];
    $model = $_POST['model'];
    $harga_per_hari = $_POST['harga_per_hari'];

    $query = "INSERT INTO kendaraan (tipe, model, harga_per_hari) VALUES ('$tipe', '$model', '$harga_per_hari')";
    $exec = mysqli_query($conn, $query);

    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data kendaraan berhasil ditambahkan!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menambahkan kendaraan: ' . mysqli_error($conn)
        ];
    }

    header('Location: kendaraan.php');
    exit();
}

// Hapus data kendaraan
if (isset($_POST['delete'])) {
    $catID = $_POST['catID'];

    $query = "DELETE FROM kendaraan WHERE kendaraan_id = '$catID'";
    $exec = mysqli_query($conn, $query);

    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data kendaraan berhasil dihapus!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menghapus kendaraan: ' . mysqli_error($conn)
        ];
    }

    header('Location: kendaraan.php');
    exit();
}

// Update data kendaraan
if (isset($_POST['update'])) {
    $catID = $_POST['catID'];
    $tipe = $_POST['tipe'];
    $model = $_POST['model'];
    $harga_per_hari = $_POST['harga_per_hari'];

    $query = "UPDATE kendaraan SET tipe='$tipe', model='$model', harga_per_hari='$harga_per_hari' WHERE kendaraan_id='$catID'";
    $exec = mysqli_query($conn, $query);

    if ($exec) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data kendaraan berhasil diperbarui!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui kendaraan: ' . mysqli_error($conn)
        ];
    }

    header('Location: kendaraan.php');
    exit();
}
?>
