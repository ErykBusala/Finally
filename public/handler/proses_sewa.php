<?php
ob_start();
include '../../koneksi.php';

header('Content-Type: application/json');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit();
}

$idProduk = isset($data['id']) ? (int) $data['id'] : 0;
$durasi = isset($data['durasi']) ? (int) $data['durasi'] : 0;
$jumlah = isset($data['jumlah']) ? (int) $data['jumlah'] : 1;
$userId = isset($data['user_id']) ? (int) $data['user_id'] : 0;

if (!$idProduk || !$durasi || !$userId) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
    exit();
}

$sql = "SELECT * FROM produk WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idProduk);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit();
}

if ($product['stok'] < $jumlah) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Stok tidak cukup']);
    exit();
}

$total = $product['harga'] * $durasi * $jumlah;
$tanggalSelesai = date('Y-m-d H:i:s', strtotime("+$durasi days"));
$newStock = $product['stok'] - $jumlah;

$conn->begin_transaction();
try {
    $sqlUpdate = "UPDATE produk SET stok = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ii", $newStock, $idProduk);
    $stmtUpdate->execute();

    if ($stmtUpdate->affected_rows > 0) {
        $sqlInsert = "INSERT INTO sewa (user_id, produk_id, tanggal_sewa, tanggal_selesai, durasi_sewa, jumlah, total_harga) VALUES (?, ?, NOW(), ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iisiii", $userId, $idProduk, $tanggalSelesai, $durasi, $jumlah, $total);
        $stmtInsert->execute();

        if ($stmtInsert->affected_rows > 0) {
            // Insert notification
            $message = "Berhasil menyewa " . $product['nama_produk'] . " sejumlah " . $jumlah . " unit.";
            $sqlNotification = "INSERT INTO notifications (user_id, message, product_id, status, created_at) VALUES (?, ?, ?, 'unread', NOW())";
            $stmtNotification = $conn->prepare($sqlNotification);
            $stmtNotification->bind_param("isi", $userId, $message, $idProduk);
            $stmtNotification->execute();

            $conn->commit();
            http_response_code(200);
            echo json_encode(['success' => true, 'total' => $total, 'tanggal_selesai' => $tanggalSelesai]);
        } else {
            throw new Exception('Gagal menyimpan data penyewaan');
        }
    } else {
        throw new Exception('Gagal memperbarui stok');
    }
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$stmt->close();
$stmtUpdate->close();
$stmtInsert->close();
$stmtNotification->close();
$conn->close();
ob_end_flush();
exit();
