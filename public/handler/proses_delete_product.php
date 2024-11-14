<?php
session_start();
include '../../koneksi.php'; // Pastikan koneksi database benar

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteProductId = $_POST['deleteProductId'];

    // Cek apakah produk sedang disewa
    $checkQuery = "SELECT COUNT(*) AS count FROM sewa WHERE produk_id = ?";
    $stmtCheck = $conn->prepare($checkQuery);
    $stmtCheck->bind_param("i", $deleteProductId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $rowCheck = $resultCheck->fetch_assoc();
    $stmtCheck->close();

    if ($rowCheck['count'] > 0) {
        // Jika produk sedang disewa, tampilkan pesan dan hentikan proses
        echo "Produk ini sedang disewa dan tidak dapat dihapus.";
    } else {
        // Jika produk tidak sedang disewa, lanjutkan penghapusan
        $sql = "DELETE FROM produk WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $deleteProductId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Produk berhasil dihapus.";
            } else {
                echo "Gagal menghapus produk. Pastikan ID produk benar.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
