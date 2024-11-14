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
            position: relative; /* To position the close icon */
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

        /* Close Icon */
        .close-icon {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            color: #333;
            cursor: pointer;
        }

        .close-icon:hover {
            color: #d46e85;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Close icon -->
       <i class="fas fa-times"></i>

        <!-- Pesan sukses -->
        <h1>Email Sudah Terdaftar!</h1>
        <p>Silahkan login.</p>

        <!-- Tombol ke halaman login -->
        <a href="../login" class="btn-login">Login</a>

    </div>
</body>
</html>
