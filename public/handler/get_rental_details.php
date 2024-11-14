<?php
include '../../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productId = $_GET['product_id'];

    // Fetch rental details based on product ID and user ID
    $sql = "SELECT * FROM sewa WHERE produk_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $productId, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rentalDetails = $result->fetch_assoc();

    if ($rentalDetails) {
        echo "<strong>Produk:</strong> " . htmlspecialchars($rentalDetails['produk_id']) . "<br>
              <strong>Tanggal Sewa:</strong> " . htmlspecialchars($rentalDetails['tanggal_sewa']) . "<br>
              <strong>Tanggal Selesai:</strong> " . htmlspecialchars($rentalDetails['tanggal_selesai']) . "<br>
              <strong>Durasi:</strong> " . htmlspecialchars($rentalDetails['durasi_sewa']) . " hari<br>
              <strong>Jumlah:</strong> " . htmlspecialchars($rentalDetails['jumlah']) . "<br>
              <strong>Total Harga:</strong> Rp" . number_format($rentalDetails['total_harga'], 0, ',', '.') . "<br>";
    } else {
        echo "Detail penyewaan tidak ditemukan.";
    }
}
