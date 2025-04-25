<?php
// Menghubungkan file konfigurasi database
include 'config.php';

// Memulai sesi PHP
session_start();

// Mendapatkan ID pengguna dari sesi
$userId = $_SESSION["user_id"];

// Menangani form untuk menambahkan postingan baru
if (isset($_POST['simpan'])) {
    // Mendapatkan data dari form
    $postTitle = $_POST["post_title"]; // Judul postingan
    $content = $_POST["content"]; // Konten postingan
    $categoryId = $_POST["category_id"]; // ID kategori

    // Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; // Nama file gambar
    $imagePath = $imageDir . basename($imageName); // Path lengkap gambar

    // Memindahkan file gambar yang diunggah ke direktori tujuan
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        // Jika unggahan berhasil, masukkan
        // data postingan ke dalam database
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, image_path) VALUES ('$postTitle', '$content', NOW(), $categoryId, $userId, '$imagePath')";
        if ($conn->query($query) === TRUE) {
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Post succesfully added.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Error adding post: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Failed to upload image.'
        ];
    }

    header('Location: dashboard.php');
    exit();
}
// Proses penghapusan postingan

    if (isset($_POST['delete'])) {

        // Mengambil ID post dari parameter URL

        $postID = $_POST['postID'];

        // Query untuk menghapus post berdasarkan ID
        $exec = mysqli_query($conn, "DELETE FROM posts WHERE id_post='$postID'");

        // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
        if ($exec) {
            $_SESSION['notification'] = [
                'message' => 'Post successfully deleted.',
                'type' => 'primary',
            ];
        } else {
            $_SESSION['notification'] = [
                'message' => 'Error deleting post: ' . mysqli_error($conn),
                'type' => 'danger',
            ];
        }

        // Redirect kembali ke halaman dashboard
        header('Location: dashboard.php');
        exit();
    }
// Mengangani pembaruan data postingan
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
  // Mendapatkan data dari form
  $postId = $_POST['post_id'];
  $postTitle = $_POST['post_title'];
  $content = $_POST['content'];
  $categoryId = $_POST['category_id'];
  $imageDir = "assets/img/uploads/"; // Direktori penyimpanan gambar

  // Periksa apakah file gambar baru diunggah
  if (!empty($_FILES["image_path"]["name"])) {
    $imageName = $_FILES["image_path"]["name"];
    $imagePath = $imageDir . $imageName;

    // Pindahkan file baru ke direktori tujuan
    move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath);

    $SqlQueryOldImage = "SELECT image_path FROM posts WHERE id_post = $postId";
    $resultOldImage =  conn::query($SqlQueryOldImage);
    if ($resultOldImage->num_rows > 0) {
      $soldImage = $resultOldImage->fetch_assoc()['image_path'];
      if (file_exists($soldImage)) {
        unlink($soldImage); // Menghapus file lama
      }
    }
  } else {
    // Jika tidak ada file baru, gunakan gambar lama
    $SqlQueryPath = "SELECT image_path FROM posts WHERE id_post = '$postId'";
    $result = conn::query($SqlQueryPath);
    $imagePath = ($result->num_rows > 0) ? $result->fetch_assoc()['image_path'] : null;
  }

  // Update data postingan di database
  $queryUpdate = "UPDATE posts SET post_title = '$postTitle', content = '$content', category_id = '$categoryId', image_path = '$imagePath' WHERE id_post = '$postId'";
  $conn->query($queryUpdate);

  if ($conn->query($queryUpdate) === TRUE) {
    // Session notifikasi
    $_SESSION['notification'] = [
      'type' => 'primary',
      'message' => 'Postingkan berhasil diperbarui.'
    ];
  } else {
    // Session notifikasi gagal
  $_SESSION['notification'] = [
    'type' => 'danger',
    'massage' => 'gagal memperbarui postingan.'
  ];
}
//arahkan ke halaman dashboard
header ('Location: dashboard.php');
exit();
}