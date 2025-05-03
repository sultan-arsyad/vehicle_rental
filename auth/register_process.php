<?php
require_once("../config.php");
// Mulai session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $nama_user = $_POST["nama_user"];
    $nomor_lisensi = $_POST["nomor_lisensi"];
    $hashedPassword = password_hash($nomor_lisensi, PASSWORD_DEFAULT);

    $sql = "INSERT INTO pelanggan (nama, nama_user, nomor_lisensi) 
            VALUES ('$nama', '$nama_user', '$hashedPassword')";
    
    if ($conn->query($sql) === TRUE) {
        // Simpan notifikasi ke dalam session
        $_SESSION['notification'] = [ 
            'type' => 'primary',
            'message' => 'Registrasi Berhasil!'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal Registrasi: ' . mysqli_error($conn)
        ];
    }
    header('Location: login.php');
    exit();
}

$conn->close();
?>
