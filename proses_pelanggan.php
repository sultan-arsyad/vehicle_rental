<?php
include 'config.php';
session_start();

if (isset($_POST['simpan'])) {
    $nama = $_POST["nama"];
    $tipe = $_POST["tipe"];
    $model = $_POST["model"];
    $nomor_lisensi = $_POST["nomor_lisensi"];
    $tanggal_rental = $_POST["tanggal_rental"];
    $tanggal_kembali = $_POST["tanggal_kembali"];
    $total = $_POST["total"];

    // Simpan pelanggan
    $queryPelanggan = "INSERT INTO pelanggan (nama, nomor_lisensi) VALUES ('$nama', '$nomor_lisensi')";
    if ($conn->query($queryPelanggan) === TRUE) {
        $pelanggan_id = $conn->insert_id;

        // Simpan kendaraan
        $queryKendaraan = "INSERT INTO kendaraan (tipe, model) VALUES ('$tipe', '$model')";
        if ($conn->query($queryKendaraan) === TRUE) {
            $kendaraan_id = $conn->insert_id;

            // Simpan data rental
            $queryRental = "INSERT INTO rental (rental_id, pelanggan_id, kendaraan_id, tgl_rental, tgl_kembali, total) 
                            VALUES ('$rental_id','$pelanggan_id', '$kendaraan_id', '$tanggal_rental', '$tanggal_kembali', '$total')";

            if ($conn->query($queryRental) === TRUE) {
                $_SESSION['notification'] = [
                    'type' => 'primary',
                    'message' => 'Data berhasil ditambahkan.'
                ];
            } else {
                $_SESSION['notification'] = [
                    'type' => 'danger',
                    'message' => 'Error menambahkan data rental: ' . $conn->error
                ];
            }
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error menambahkan data kendaraan: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Error menambahkan data pelanggan: ' . $conn->error
        ];
    }

    header('Location: rental.php');
    exit();
}

// Proses penghapusan pelanggan
if (isset($_POST['delete'])) {
    $rentalID = $_POST['rental_id'];

    $exec = mysqli_query($conn, "DELETE FROM rental WHERE rental_id = '$pelangganID'");
    if ($exec) {
        $_SESSION['notification'] = [
            'message' => 'Data pelanggan berhasil dihapus.',
            'type' => 'primary',
        ];
    } else {
        $_SESSION['notification'] = [
            'message' => 'Error menghapus data pelanggan: ' . mysqli_error($conn),
            'type' => 'danger',
        ];
    }

    header('Location: rental.php');
    exit();
}

// Proses pembaruan data pelanggan
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $pelangganID = $_POST['pelanggan_id'];
    $nama = $_POST['nama'];
    $nomor_lisensi = $_POST['nomor_lisensi'];

    $queryUpdate = "UPDATE pelanggan SET nama = '$nama', nomor_lisensi = '$nomor_lisensi' WHERE pelanggan_id = '$pelangganID'";
    if ($conn->query($queryUpdate) === TRUE) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data pelanggan berhasil diperbarui.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui data pelanggan: ' . $conn->error
        ];
    }

    header('Location: rental.php');
    exit();
}
?>
