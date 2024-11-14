<?php
// Mulai sesi
session_start();
require '../../../koneksi.php'; // File koneksi.php ke database
require '../../../vendor/autoload.php'; // autoload.php PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ambil email dari POST atau dari sesi jika tersedia
$email = isset($_POST['email']) ? trim($_POST['email']) : (isset($_SESSION['unverified_email']) ? $_SESSION['unverified_email'] : '');

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email tidak disediakan atau kosong']);
    exit;
}

// Validasi format email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Format email tidak valid']);
    exit;
}

// Query untuk mencari user berdasarkan email
$stmt = $conn->prepare("SELECT id, email, email_verified, email_verification_token, resend_count, last_verification_email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cek apakah user ditemukan
if (!$user) {
    echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
    exit;
}

// Cek apakah user sudah diverifikasi
if ($user['email_verified']) {
    echo json_encode(['status' => 'error', 'message' => 'Akun sudah diverifikasi']);
    exit;
}

// Batasi pengiriman ulang link verifikasi (5 kali per 24 jam)
if ($user['resend_count'] >= 5 && time() - strtotime($user['last_verification_email']) < 86400) {
    echo json_encode(['status' => 'error', 'message' => 'Batas pengiriman ulang tercapai, coba lagi dalam 24 jam.']);
    exit;
}

// Generate token verifikasi baru
$token = bin2hex(random_bytes(16));

// Update token dan waktu pengiriman terakhir
$stmt = $conn->prepare("UPDATE users SET email_verification_token = ?, last_verification_email = NOW(), resend_count = resend_count + 1 WHERE id = ?");
$stmt->bind_param("si", $token, $user['id']);
$stmt->execute();

// Kirim email verifikasi menggunakan PHPMailer
if (sendVerificationEmail($email, $token)) {
    echo json_encode(['status' => 'success', 'message' => 'Link verifikasi telah dikirim ulang']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengirim email']);
}

// Fungsi untuk mengirim email verifikasi
function sendVerificationEmail($email, $token) {
    $appName = "MUA MAKEUP";
    $verificationLink = "http://localhost/nigastrep/public/pluggin/handler/verify?token=" . $token;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ikhsannurfadilh@gmail.com';
        $mail->Password = 'tdku bgnw iozj mtjn'; // Password aplikasi Gmail, lebih baik disimpan di file .env atau konfigurasi server
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@yourdomain.com', $appName);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Verifikasi Email Anda";
        $mail->Body = "
            <h2>Verifikasi Email Anda</h2>
            <p>Hi! Klik tautan di bawah ini untuk memverifikasi email Anda dan menyelesaikan pendaftaran Anda:</p>
            <a href='$verificationLink'>$verificationLink</a>
            <br><br>
            <p>Jika Anda tidak mendaftar di $appName, silakan abaikan email ini.</p>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email tidak dapat dikirim. Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
