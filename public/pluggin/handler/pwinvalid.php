<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid or Expired Token</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 60px;
            color: #ffc107; /* Warna kuning untuk ikon peringatan */
        }

        .card-title {
            color: #ffc107; /* Warna kuning untuk teks peringatan */
            font-size: 24px;
            margin-top: 15px;
        }

        .btn-home {
            background-color: #ffc107;
            border: none;
        }

        .btn-home:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <!-- Ikon peringatan -->
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle card-icon"></i>
                        <!-- Pesan token tidak valid atau kadaluarsa -->
                        <h1 class="card-title">Tidak ada atau Token telah Expired</h1>
                        <p class="card-text mt-3">Token tidak valid atau kadaluarsa silahkan request ulang.</p>
                        <!-- Tombol ke halaman reset password -->
                        <a href="forgot_password" class="btn btn-home text-white mt-4 px-4">Request New Token</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS dan dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
