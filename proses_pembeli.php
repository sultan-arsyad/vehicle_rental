<?php
include 'config.php';
session_start();

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $NIK = $_POST['NIK'];
    $simPath = null;

    // Proses upload file SIM
    if (isset($_FILES['sim']) && $_FILES['sim']['error'] === 0) {
        $uploadDir = 'uploads/sim/';
        
        // Buat folder jika belum ada
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['sim']['name']);
        $simPath = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES['sim']['tmp_name'], $simPath)) {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Gagal mengunggah foto SIM.'
            ];
            header("Location: pelanggan.php");
            exit();
        }
    }

    // Simpan data pelanggan ke database
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama, NIK, sim) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $NIK, $simPath);

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Data pelanggan berhasil disimpan.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal menyimpan data pelanggan: ' . $conn->error
        ];
    }

    $stmt->close();
    header("Location: pembeli.php");
    exit();
}
?>
