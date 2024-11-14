<?php
include '../../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $notificationId = $_POST['id'];

    // Prepare the SQL DELETE statement
    $sql = "DELETE FROM notifications WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $notificationId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Notifikasi berhasil dihapus.";
        } else {
            echo "Gagal menghapus notifikasi. Pastikan ID notifikasi benar.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
