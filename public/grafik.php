<?php
session_start();
include '../koneksi.php'; // Pastikan 'koneksi.php' berisi koneksi $conn

// Menampilkan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data produk dan stoknya
$sql = "SELECT nama_produk, stok FROM produk"; // Ganti 'produk' dengan nama tabel produk Anda
$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result->num_rows > 0) {
    // Output data per baris
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['nama_produk']; // Menambahkan nama produk ke labels
        $data[] = $row['stok']; // Menambahkan stok produk ke data
    }
} else {
    echo "0 results";
}
$conn->close();

// Mengembalikan data dalam format JSON
echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
