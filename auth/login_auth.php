<?php  
session_start();  
require_once("../config.php");  
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $nama = $_POST["nama"];  
    $nomor_lisensi = $_POST["nomor_lisensi"];  
  
    $sql = "SELECT * FROM pelanggan WHERE nama ='$nama'";  
    $result = $conn->query($sql);  
  
    if ($result->num_rows > 0) {  
        $row = $result->fetch_assoc();  
        // Verifikasi password  
        if (password_verify($, $row["nomor_lisensi"])) {  
            $_SESSION["nama"] = $nama;  
            $_SESSION["nomor_lisensi"] = $row["nomor_lisensi"];    
            $_SESSION["pelanggan_id"] = $row["pelanggan_id"];  
            // Set notifikasi selamat datang  
            $_SESSION['notification'] = [  
                'type' => 'primary',  
                'message' => 'Selamat Datang Kembali!'  
            ];  
            // Redirect ke dashboard  
            header('Location: ../dashboard.php');  
            exit();  
        } else {  
            // Password salah  
            $_SESSION['notification'] = [  
                'type' => 'danger',  
                'message' => 'Username atau Password salah'  
            ];  
        }  
     } else {  
 // Username tidak ditemukan  
     $_SESSION['notification'] = [  
 'type' => 'danger',  
     'message' => 'Username atau Password salah'  
     ];  
     }  
     // Redirect kembali ke halaman login jika gagal  
     header('Location: login.php');  
     exit();
    }    
     $conn->close();  
 ?>