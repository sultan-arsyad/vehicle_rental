<?php
session_start();
include 'config.php'; // koneksi ke database

// === TAMBAH DATA PELANGGAN ===
if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $nik = trim($_POST['NIK']);

    if (empty($nama) || empty($nik)) {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Nama dan NIK wajib diisi.'
        ];
        header('Location: pembeli.php');
        exit;
    }

    if (isset($_FILES['sim']) && $_FILES['sim']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = $_FILES['sim']['type'];
        $file_size = $_FILES['sim']['size'];
        $tmp_name = $_FILES['sim']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['sim']['name']);
        $upload_dir = 'uploads/';

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Format file SIM harus JPG atau PNG.'];
            header('Location: pembeli.php');
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Ukuran file SIM maksimal 2MB.'];
            header('Location: pembeli.php');
            exit;
        }

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
            $nama_escaped = mysqli_real_escape_string($conn, $nama);
            $nik_escaped = mysqli_real_escape_string($conn, $nik);
            $file_name_escaped = mysqli_real_escape_string($conn, $file_name);

            $sql = "INSERT INTO pelanggan (nama, NIK, sim) VALUES ('$nama_escaped', '$nik_escaped', '$file_name_escaped')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['notification'] = ['type' => 'success', 'message' => 'Data pelanggan berhasil disimpan.'];
            } else {
                $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menyimpan data pelanggan: ' . mysqli_error($conn)];
                unlink($upload_dir . $file_name);
            }
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal mengupload file SIM.'];
        }
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'File SIM wajib diupload.'];
    }

    header('Location: pembeli.php');
    exit;
}

// === EDIT DATA PELANGGAN ===
if (isset($_POST['edit'])) {
    $id = intval($_POST['pelanggan_id']);
    $nama = trim($_POST['nama']);
    $nik = trim($_POST['NIK']);

    if (empty($nama) || empty($nik)) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Nama dan NIK tidak boleh kosong.'];
        header('Location: pembeli.php');
        exit;
    }

    $update_sim = "";
    if (isset($_FILES['sim']) && $_FILES['sim']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $file_type = $_FILES['sim']['type'];
        $file_size = $_FILES['sim']['size'];
        $tmp_name = $_FILES['sim']['tmp_name'];
        $file_name = time() . '_' . basename($_FILES['sim']['name']);
        $upload_dir = 'uploads/';

        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Format file SIM harus JPG atau PNG.'];
            header('Location: pembeli.php');
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Ukuran file SIM maksimal 2MB.'];
            header('Location: pembeli.php');
            exit;
        }

        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
            $file_name_escaped = mysqli_real_escape_string($conn, $file_name);

            // Ambil nama file lama untuk dihapus
            $old_file = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sim FROM pelanggan WHERE pelanggan_id = $id"))['sim'];
            if ($old_file && file_exists($upload_dir . $old_file)) {
                unlink($upload_dir . $old_file);
            }

            $update_sim = ", sim = '$file_name_escaped'";
        } else {
            $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal mengupload file SIM.'];
            header('Location: pembeli.php');
            exit;
        }
    }

    $nama_escaped = mysqli_real_escape_string($conn, $nama);
    $nik_escaped = mysqli_real_escape_string($conn, $nik);

    $sql = "UPDATE pelanggan SET nama = '$nama_escaped', NIK = '$nik_escaped' $update_sim WHERE pelanggan_id = $id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Data pelanggan berhasil diperbarui.'];
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal mengedit data pelanggan: ' . mysqli_error($conn)];
    }

    header('Location: pembeli.php');
    exit;
}

// === HAPUS DATA PELANGGAN ===
if (isset($_POST['hapus'])) {
    $id = intval($_POST['pelanggan_id']);
    $upload_dir = 'uploads/';

    // Ambil nama file untuk dihapus
    $result = mysqli_query($conn, "SELECT sim FROM pelanggan WHERE pelanggan_id = $id");
    $data = mysqli_fetch_assoc($result);
    if ($data && file_exists($upload_dir . $data['sim'])) {
        unlink($upload_dir . $data['sim']);
    }

    $sql = "DELETE FROM pelanggan WHERE pelanggan_id = $id";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['notification'] = ['type' => 'success', 'message' => 'Data pelanggan berhasil dihapus.'];
    } else {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'Gagal menghapus data pelanggan: ' . mysqli_error($conn)];
    }

    header('Location: pembeli.php');
    exit;
}

// === AKSES LANGSUNG TANPA Aksi yang dikenali ===
header('Location: pembeli.php');
exit;
?>
