<?php

//konfigurasi koneksi database
$host = "localhost";//nama host server database
$username = "root";//username untuk akses ke database
$password ="";//pasword untuk akses ke databse
$database = "vehicle_rental";//nama database yg digunakan

// membuat koneksi ke database mengguanakan databse mysqli
$conn = mysqli_connect($host,$username,$password,$database);

// mengecek apakah koneksi berhasil
if ($conn->connect_error){
    //menampilkan pesan eror jika koneksi gagal
    die ("database gagal terkoneksi: ". $conn->connect_error);

    //jika koneksi berhasil script akan jalan tanpa pesan eror

}
?>