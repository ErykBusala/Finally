<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Cek Email Anda</title>
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
            background-color: #ffe6f0;
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
            font-size: 60px;
            color: #ff85b3; /* Warna merah muda */
            margin-bottom: 20px;
        }

        .container h1 {
            color: #ff85b3; /* Warna merah muda */
            font-size: 24px;
            margin-bottom: 10px;
        }

        .container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .btn-home {
            display: inline-block;
            background-color: #ff85b3; /* Warna merah muda */
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-home:hover {
            background-color: #e57399; /* Warna merah muda gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Icon Email -->
        <i class="fas fa-envelope"></i>

        <!-- Pesan Utama -->
        <h1 style="font-weight: bold;">Gagal Mngirim Email Anda!</h1>
        <p>Silakan inputkan kembali email Anda.</p>

        <!-- Tombol ke Beranda -->
        <a href="../login" class="btn-home">Kembali</a>
    </div>
</body>
</html>
