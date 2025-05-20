<?php
include 'koneksi.php'; // Sesuaikan dengan koneksi Anda

if (isset($_GET['tipe'])) {
    $tipe = $_GET['tipe'];
    $query = "SELECT DISTINCT model FROM kendaraan WHERE tipe = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tipe);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<option value="" disabled selected>Pilih Model</option>';
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . htmlspecialchars($row['model']) . '">' . htmlspecialchars($row['model']) . '</option>';
    }
}
?>
