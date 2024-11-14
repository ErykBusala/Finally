<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Failed</title>
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
            color: #dc3545; /* Warna merah untuk ikon gagal */
        }

        .card-title {
            color: #dc3545; /* Warna merah untuk teks gagal */
            font-size: 24px;
            margin-top: 15px;
        }

        .btn-try-again {
            background-color: #dc3545;
            border: none;
        }

        .btn-try-again:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <!-- Ikon gagal -->
                    <div class="card-body">
                        <i class="fas fa-times-circle card-icon"></i>
                        <!-- Pesan gagal -->
                        <h1 class="card-title">Failed to reset password</h1>
                        <p class="card-text mt-3">Please try again later. If the issue persists, contact support.</p>
                        <!-- Tombol coba lagi -->
                        <a href="reset_password" class="btn btn-try-again text-white mt-4 px-4">Try Again</a>
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
