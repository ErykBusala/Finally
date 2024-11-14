<?php
session_start();
include '../../koneksi.php'; // Ensure the database connection is included

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['productId'];
    $newStock = $_POST['newStock'];

    // Update the stock for the specified product
    $sql = "UPDATE produk SET stok = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $newStock, $productId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Stok berhasil diupdate.";
        } else {
            echo "Gagal mengupdate stok. Pastikan ID produk benar.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
