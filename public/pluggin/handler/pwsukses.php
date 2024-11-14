<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Success</title>
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
            color: #28a745; /* Warna hijau untuk ikon sukses */
        }

        .card-title {
            color: #28a745; /* Warna hijau untuk teks sukses */
            font-size: 24px;
            margin-top: 15px;
        }

        .btn-home {
            background-color: #28a745;
            border: none;
        }

        .btn-home:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <!-- Ikon sukses -->
                    <div class="card-body">
                        <i class="fas fa-check-circle card-icon"></i>
                        <!-- Pesan sukses -->
                        <h1 class="card-title">Password has been successfully reset!</h1>
                        <p class="card-text mt-3">You can now log in with your new password.</p>
                        <!-- Tombol ke halaman login -->
                        <a href="../login" class="btn btn-home text-white mt-4 px-4">Go to Login</a>
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
