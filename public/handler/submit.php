<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan Secret Key cocok dengan tipe reCAPTCHA yang dipilih
    $secretKey = "6Le9C34qAAAAAJiKgqLIDytqvIl0hZ0m_CbuqD5y";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];
    
    // Verifikasi reCAPTCHA di server Google
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP");
    $response = json_decode($response);
    
    if ($response->success) {
        header("Location: ../dashboard.php");
    } else {
        header("location: ./error.php");
    }
}
?>
