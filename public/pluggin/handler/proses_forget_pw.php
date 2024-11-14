<?php
// Menghubungkan ke database
include '../../../koneksi.php';
require '../../../vendor/autoload.php'; // Memasukkan PHPMailer setelah di-install via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$appName = "MUA MAKEUP"; 
$fullname = $_POST['fullname'];
// Mendapatkan email dari form lupa password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    // Mencari pengguna berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika pengguna ditemukan
    if ($result->num_rows > 0) {
        // Buat token reset password
        $token = bin2hex(random_bytes(50));

        // Menyimpan token di database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Mengirim email reset password
        if (sendResetPasswordEmail($email, $token, $appName, $fullname)) {
            header("Location: emailVerif");
            exit();
        } else {
            header("Location: gagalEmail");
            exit();
        }
    } else {
        header("Location: notverifiedEmail");
    }

    $stmt->close();
    $conn->close();
}

// Fungsi untuk mengirim email reset password
function sendResetPasswordEmail($email, $token, $appName, $fullname) {
    $mail = new PHPMailer(true);

    try {
        // Pengaturan server email
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Gunakan server SMTP yang sesuai
        $mail->SMTPAuth = true;
        $mail->Username = 'ikhsannurfadilh@gmail.com'; // Ganti dengan email Anda
        $mail->Password = 'tdku bgnw iozj mtjn'; // Ganti dengan app-specific password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Penerima email
        $mail->setFrom('your-email@gmail.com', $appName);
        $mail->addAddress($email);

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password Anda';
        $resetLink = "http://localhost/nigastrep/public/pluggin/handler/reset_password?token=$token";
        $mail->Body = "
      <div style='background-color:#f7f4f3; padding:20px; font-family:Arial, sans-serif; color:#333;'>
    <div style='max-width:600px; margin:auto;'>
        <div style='text-align:center; padding:10px 0;'>
            <img src='https://i.etsystatic.com/39445345/r/il/552c36/4779286524/il_1588xN.4779286524_ae8f.jpg' alt='Makeup Header' style='width:100%; max-width:400px;' />
        </div>
        <div style='background-color:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1);'>
            <h2 style='color:#d46e85; text-align:center;'>Reset Password Anda di <b>$appName</b></h2>
            <p style='font-size:16px; text-align:center;'>Hi, <b>$fullname</b>!</p>
            <p style='font-size:16px; text-align:center;'>Kami menerima permintaan untuk mereset kata sandi Anda. Klik tombol di bawah ini untuk melanjutkan proses reset.</p>
            <div style='text-align:center; margin-top:30px;'>
                <a href='$resetLink' style='padding:15px 25px; background-color:#d46e85; color:#fff; text-decoration:none; border-radius:4px;'>Reset Password</a>
            </div>
            <p style='font-size:14px; text-align:center; margin-top:20px;'>Jika Anda tidak meminta reset password, silakan abaikan email ini.</p>
        </div>
        <div style='text-align:center; margin-top:20px; font-size:12px; color:#999;'>
            &copy; 2024 $appName. All rights reserved.
        </div>
    </div>
</div>

    ";

        // Kirim email
        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>
