<?php
session_start();
include '../../koneksi.php';

// Load dotenv
require '../../vendor/autoload.php'; // Sesuaikan path ke autoload.php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../'); 
$dotenv->load();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek apakah email cocok dengan salah satu admin di .env
    $isAdmin = false;
    $adminIndex = 1;

    // Loop untuk memeriksa beberapa admin yang disimpan di .env
    while (isset($_ENV["EMAIL_ADMIN{$adminIndex}"])) {
        $adminEmail = $_ENV["EMAIL_ADMIN{$adminIndex}"];
        $adminPassword = $_ENV["PASSWORD_ADMIN{$adminIndex}"];

        // Periksa jika email dan password cocok
        if ($email === $adminEmail && $password === $adminPassword) {
            $isAdmin = true;
            break;
        }
        $adminIndex++;
    }

    if ($isAdmin) {
        // Set session dan arahkan ke halaman admin
        $_SESSION['user_id'] = 'admin_' . $adminIndex;  // ID unik untuk admin
        $_SESSION['email'] = $email;
        $_SESSION['username'] = 'Admin';
        $_SESSION['is_admin'] = true;
        header("Location: ../admin_dashboard.php");
        exit();
    }

    // Query untuk pengguna reguler jika bukan admin
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password pengguna reguler
        if (password_verify($password, $user['password'])) {
            if ($user['email_verified'] == 1) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_verified'] = $user['email_verified'];
                header("Location: ../world.php");
                exit();
            } else {
                $_SESSION['unverified_email'] = $email;
                header("Location: ../pluggin/handler/verified.php");

                exit();
            }
        } else {
            header("Location: ../pluggin/handler/wrongpw.php");
            exit();
        }
    } else {
        header("Location: ../pluggin/handler/notverified.php");
        exit();
    }

    $stmt->close();
} else {
    echo "Email dan password harus diisi.";
}

$conn->close();
?>
