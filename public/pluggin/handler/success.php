<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Berhasil - MUA Makeup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f3f3;
            color: #333;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        .container i {
            font-size: 80px;
            color: #d46e85;
            margin-bottom: 20px;
        }

        .container h1 {
            color: #d46e85;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-login {
            display: inline-block;
            background-color: #d46e85;
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #c0556a;
        }

        .container .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
        }

        .container .footer a {
            color: #d46e85;
            text-decoration: none;
        }

        .container .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Icon sukses -->
        <i class="fas fa-check-circle"></i>

        <!-- Pesan sukses -->
        <h1>Verifikasi Berhasil!</h1>
        <p>Terima kasih telah memverifikasi akun Anda. Kini Anda dapat login ke aplikasi MUA Makeup.</p>

        <!-- Tombol ke halaman login -->
        <a href="../login" class="btn-login">Masuk ke Akun</a>

    </div>
</body>
</html>
