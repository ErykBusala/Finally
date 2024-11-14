<?php
// Menghubungkan ke database
include '../../../koneksi.php';
require '../../../vendor/autoload.php'; // Memasukkan PHPMailer setelah menginstal via Composer
session_start(); // Memulai sesi untuk menyimpan pesan

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$appName = "MUA MAKEUP"; // Nama aplikasi

// Mendapatkan data dari form register
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Menggunakan hashing untuk keamanan
$fullname = $_POST['fullname'];
$date_of_birth = $_POST['date_of_birth'];

// Validasi domain email yang diperbolehkan
$allowed_domains = ['gmail.com', 'mhs.ubpkarawang.ac.id'];
$email_domain = substr(strrchr($email, "@"), 1); // Mendapatkan domain email

// Cek apakah domain email valid
if (!in_array($email_domain, $allowed_domains)) {
    $_SESSION['error_message'] = "Hanya email dengan domain @gmail.com atau @mhs.ubpkarawang.ac.id yang diperbolehkan.";
    header("Location: notvalidemail"); // Redirect ke halaman register dengan pesan kesalahan
    exit();
}

// Memeriksa apakah email sudah terdaftar
$emailCheckSql = "SELECT * FROM users WHERE email = ?";
$emailCheckStmt = $conn->prepare($emailCheckSql);
$emailCheckStmt->bind_param("s", $email);
$emailCheckStmt->execute();
$emailCheckResult = $emailCheckStmt->get_result();

// Cek apakah email sudah digunakan
if ($emailCheckResult->num_rows > 0) {
    $_SESSION['error_message'] = "Email sudah terdaftar. Silakan gunakan email lain.";
    header("Location: emailganda"); // Redirect ke halaman khusus email ganda
    exit();
} else {
    // Jika email belum terdaftar, masukkan data pengguna baru
    $token = bin2hex(random_bytes(16)); // Token untuk verifikasi email
    $sql = "INSERT INTO users (username, email, password, fullname, date_of_birth, email_verification_token) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $email, $password, $fullname, $date_of_birth, $token);

    if ($stmt->execute()) {
        if (sendVerificationEmail($email, $token, $appName, $fullname)) {
            $_SESSION['success_message'] = "Registrasi berhasil! Silakan cek email Anda untuk memverifikasi akun.";
            header("Location: success"); // Redirect ke halaman sukses
            exit();
        } else {
            $_SESSION['error_message'] = "Registrasi berhasil, tetapi email verifikasi tidak bisa dikirim.";
            header("Location: notvalidemail"); // Redirect ke halaman error email
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Terjadi kesalahan saat mendaftarkan pengguna: " . $stmt->error;
        header("Location: login");
        exit();
    }

    $stmt->close();
}

$emailCheckStmt->close();
$conn->close();

// Fungsi untuk mengirim email verifikasi
function sendVerificationEmail($email, $token, $appName, $fullname) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ikhsannurfadilh@gmail.com';
        $mail->Password = 'tdku bgnw iozj mtjn'; // Password aplikasi Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your-email@gmail.com', $appName);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Verifikasi Email Anda - $appName";
        $verificationLink = "http://localhost/nigastrep/public/pluggin/handler/verify?token=$token";
        
        $mail->Body = "
            <div style='background-color:#f7f4f3; padding:20px; font-family:Arial, sans-serif; color:#333;'>
                <div style='max-width:600px; margin:auto;'>
                    <div style='text-align:center; padding:10px 0;'>
                        <img src='https://i.etsystatic.com/39445345/r/il/552c36/4779286524/il_1588xN.4779286524_ae8f.jpg' alt='Makeup Header' style='width:100%; max-width:400px;' />
                    </div>
                    <div style='background-color:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);'>
                        <h2 style='color:#d46e85; text-align:center;'>Selamat Datang di <b>$appName</b>!</h2>
                        <p style='font-size:16px; text-align:center;'>Hi, <b>$fullname</b>!</p>
                        <p style='font-size:16px; text-align:center;'>Terima kasih telah mendaftar di <b>$appName</b>. Satu langkah lagi untuk menyempurnakan perjalanan Anda.</p>
                        <div style='text-align:center; margin-top:30px;'>
                            <a href='$verificationLink' style='padding:15px 25px; background-color:#d46e85; color:#fff; text-decoration:none; border-radius:4px;'>Verifikasi Email Saya</a>
                        </div>
                        <p style='font-size:14px; text-align:center; margin-top:20px;'>Jika Anda tidak mendaftar di $appName, silakan abaikan email ini.</p>
                    </div>
                    <div style='text-align:center; margin-top:20px; font-size:12px; color:#999;'>
                        &copy; 2024 $appName. All rights reserved.
                    </div>
                </div>
            </div>
        ";

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
