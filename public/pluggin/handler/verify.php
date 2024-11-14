<?php
// Menghubungkan ke database
include '../../../koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Menyiapkan query untuk memverifikasi akun
    $sql = "UPDATE users SET email_verified = 1 WHERE email_verification_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Jika verifikasi berhasil
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height for vertical centering */
            margin: 0;
        }
        .container {
            max-width: 500px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #d46e85;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 30px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .alert-link {
            color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">Verifikasi Berhasil!</h4>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Akun Anda telah berhasil diverifikasi. Silakan <a href="../login" class="alert-link">login</a> untuk mengakses akun Anda.</p>
                <hr>
                <p class="mb-0">Selamat datang di aplikasi kami!</p>
                <a href="../login" class="btn btn-custom mt-3">Login</a>
            </div>
        </div>
    </div>

    <!-- Link ke jQuery dan Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

            ';
        } else {
            echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Gagal</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height for vertical centering */
            margin: 0;
        }
        .container {
            max-width: 500px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #d46e85;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card-body {
            padding: 30px;
        }
        .alert-link {
            color: #007bff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">Verifikasi Gagal! TOKEN TIDAK TERSEDIA!</h4>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Akun Anda gagal diverifikasi. Silakan cek kembali email Anda pada bagian Inbox atau Spam untuk melihat token yang baru dikirim. Klik <a href="https://mail.google.com/mail/u/0/?hl=en#inbox" class="alert-link">Inbox</a> atau <a href="https://mail.google.com/mail/u/0/?hl=en#spam" class="alert-link">Spam</a>.</p>
            </div>
        </div>
    </div>

    <!-- Link ke jQuery dan Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
';
    }
}
}