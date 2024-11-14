<?php
session_start();
include '../../koneksi.php'; // Pastikan 'koneksi.php' berisi koneksi $conn

// Menampilkan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pastikan koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah data dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form dan memvalidasinya
    $nama_produk = isset($_POST['productName']) ? $_POST['productName'] : '';
    $harga = isset($_POST['productPrice']) ? (int) $_POST['productPrice'] : 0;
    $kategori = isset($_POST['productCategory']) ? $_POST['productCategory'] : '';
    $deskripsi = isset($_POST['productDescription']) ? $_POST['productDescription'] : '';
    $stok = isset($_POST['productStock']) ? (int) $_POST['productStock'] : 0;

    // Proses unggah gambar
    $gambar_produk = "";
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $target_dir = "../../public/uploads/"; // Path direktori unggahan yang sesuai
        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                echo "Error: Gagal membuat folder uploads.";
                exit();
            }
        }
        $file_name = basename($_FILES["productImage"]["name"]);
        $gambar_produk = $target_dir . $file_name; // Path server untuk penyimpanan file

        // Proses upload file
        if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $gambar_produk)) {
            echo "Error: Gagal mengunggah gambar produk.";
            exit();
        }

        // Simpan URL gambar relatif untuk akses publik
        $gambar_produk = "uploads/" . $file_name; // Path relatif dari root project
    }

    // Persiapkan dan eksekusi perintah SQL
    $sql = "INSERT INTO produk (nama_produk, harga, kategori, deskripsi, gambar_produk, stok, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sisssi", $nama_produk, $harga, $kategori, $deskripsi, $gambar_produk, $stok);

        if ($stmt->execute()) {
            echo "Produk berhasil ditambahkan!";
        } else {
            echo "Error saat eksekusi: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error saat persiapan statement: " . $conn->error;
    }
} else {
    echo "Error: Metode request tidak sesuai.";
}

$conn->close();
?>
