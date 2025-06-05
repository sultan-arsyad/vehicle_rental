<?php
include 'config.php';
session_start();

$userId = $_SESSION["user_id"];

if (isset($_POST['simpan'])) {
    // Ambil data pelanggan
    $nama = $_POST["nama"];
    $NIK = $_POST["NIK"];

    // Simpan ke tabel pelanggan
    $queryPelanggan = "INSERT INTO pelanggan (nama, NIK) VALUES ('$nama', '$nomorLisensi')";

    if ($conn->query($queryPelanggan) === TRUE) {
        // Ambil ID pelanggan yang baru saja ditambahkan
        $pelangganId = $conn->insert_id;

        // Ambil data rental
        $kendaraanId = $_POST["kendaraan_id"];
        $tglRental = $_POST["tgl_rental"];
        $tglKembali = $_POST["tgl_kembali"];

        // Hitung selisih hari
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
                'message' => 'Data pelanggan dan rental berhasil ditambahkan.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data rental: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data pelanggan: ' . $conn->error
        ];
    }

    if (isset($_POST['proses_pelanggan'])) {
        $rental_id = $_POST['rental_id'];
        $pelanggan_id = $_POST['pelanggan_id'];
        $kendaraan_id = $_POST['kendaraan_id'];
        $tgl_rental = $_POST['tgl_rental'];
        $tgl_kembali = $_POST['tgl_kembali'];
        $total = $_POST['total'];
    
        $updateQuery = "UPDATE rental SET 
                            pelanggan_id = '$pelanggan_id', 
                            kendaraan_id = '$kendaraan_id',
                            tgl_rental = '$tgl_rental',
                            tgl_kembali = '$tgl_kembali',
                            total = '$total'
                        WHERE rental_id = '$rental_id'";
    
        if (mysqli_query($conn, $updateQuery)) {
            header("Location: rental.php?status=success");
        } else {
            echo "Gagal update: " . mysqli_error($conn);
        }
    }    

    header("Location: rental.php");
    exit();
}
?>