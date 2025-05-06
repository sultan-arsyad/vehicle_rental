<?php
include 'config.php';
session_start();

// Hapus data rental
if (isset($_GET['hapus']) && isset($_GET['rental_id'])) {
    $rental_id = $_GET['rental_id'];

    $stmt = $conn->prepare("DELETE FROM rental WHERE rental_id = ?");
    $stmt->bind_param("i", $rental_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data rental berhasil dihapus.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menghapus data: ' . $stmt->error
        ];
    }

    $stmt->close();
    header("Location: rental.php");
    exit();
}

// Update data rental
if (isset($_POST['proses_pelanggan'])) {
    $rental_id = $_POST['rental_id'];
    $pelanggan_id = $_POST['pelanggan_id'];
    $kendaraan_id = $_POST['kendaraan_id'];
    $tgl_rental = $_POST['tgl_rental'];
    $tgl_kembali = $_POST['tgl_kembali'];

    // Hitung ulang selisih hari
    $start = new DateTime($tgl_rental);
    $end = new DateTime($tgl_kembali);
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
    $stmt = $conn->prepare("SELECT harga_per_hari FROM kendaraan WHERE kendaraan_id = ?");
    $stmt->bind_param("i", $kendaraan_id);
    $stmt->execute();
    $stmt->bind_result($harga_per_hari);
    $stmt->fetch();
    $stmt->close();

    $total = $selisih * $harga_per_hari;

    // Update rental
    $stmt = $conn->prepare("UPDATE rental SET pelanggan_id = ?, kendaraan_id = ?, tgl_rental = ?, tgl_kembali = ?, total = ? WHERE rental_id = ?");
    $stmt->bind_param("iissdi", $pelanggan_id, $kendaraan_id, $tgl_rental, $tgl_kembali, $total, $rental_id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data rental berhasil diperbarui.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal update: ' . $stmt->error
        ];
    }

    $stmt->close();
    header("Location: rental.php");
    exit();
}

// Tambah data pelanggan dan rental
if (isset($_POST['simpan'])) {
    $nama = $_POST["nama"];
    $nomorLisensi = $_POST["nomor_lisensi"];
    $kendaraanId = $_POST["kendaraan_id"];
    $tglRental = $_POST["tgl_rental"];
    $tglKembali = $_POST["tgl_kembali"];

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

    // Simpan pelanggan
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, nomor_lisensi) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $nomorLisensi);

    if ($stmt->execute()) {
        $pelangganId = $stmt->insert_id;
        $stmt->close();

        // Ambil harga kendaraan
        $stmt = $conn->prepare("SELECT harga_per_hari FROM kendaraan WHERE kendaraan_id = ?");
        $stmt->bind_param("i", $kendaraanId);
        $stmt->execute();
        $stmt->bind_result($hargaPerHari);
        $stmt->fetch();
        $stmt->close();

        $total = $selisih * $hargaPerHari;

        // Simpan data rental
        $stmt = $conn->prepare("INSERT INTO rental (pelanggan_id, kendaraan_id, tgl_rental, tgl_kembali, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iissd", $pelangganId, $kendaraanId, $tglRental, $tglKembali, $total);

        if ($stmt->execute()) {
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Data pelanggan dan rental berhasil ditambahkan.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Gagal menyimpan data rental: ' . $stmt->error
            ];
        }

        $stmt->close();
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data pelanggan: ' . $stmt->error
        ];
    }

    header("Location: rental.php");
    exit();
}
?>
