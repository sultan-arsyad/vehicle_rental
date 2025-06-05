<?php
include 'config.php';
session_start();

$userId = $_SESSION["user_id"];

if (isset($_POST['simpan'])) {
    // Ambil data rental
    $pelangganId = $_POST["pelanggan_id"]; // DARI FORM PILIHAN
    $kendaraanId = $_POST["kendaraan_id"];
    $tglRental = $_POST["tgl_rental"];
    $tglKembali = $_POST["tgl_kembali"];

    // Validasi tanggal
    $start = new DateTime($tglRental);
    $end = new DateTime($tglKembali);
    $selisih = $start->diff($end)->days;

    if ($selisih < 1) {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Tanggal kembali harus setelah tanggal rental.'
        ];
        header("Location: rental.php");
        exit();
    }

    // Ambil harga kendaraan
    $result = $conn->query("SELECT harga_per_hari FROM kendaraan WHERE kendaraan_id = '$kendaraanId'");
    $row = $result->fetch_assoc();
    $hargaPerHari = $row['harga_per_hari'];

    $total = $selisih * $hargaPerHari;

    // Simpan ke tabel rental
    $queryRental = "INSERT INTO rental (pelanggan_id, kendaraan_id, tgl_rental, tgl_kembali, total)
                    VALUES ('$pelangganId', '$kendaraanId', '$tglRental', '$tglKembali', '$total')";

    if ($conn->query($queryRental) === TRUE) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data rental berhasil ditambahkan.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data rental: ' . $conn->error
        ];
    }

    header("Location: rental.php");
    exit();
}
?>