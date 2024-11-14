<?php
session_start();
$email = isset($_SESSION['unverified_email']) ? $_SESSION['unverified_email'] : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Belum Terverifikasi</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .notification {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container notification">
        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">Akun Belum Terverifikasi!</h4>
            <p>Silakan lakukan verifikasi akun Anda terlebih dahulu untuk mengakses fitur-fitur di dalam aplikasi ini. <a href="../login">Login</a></p>
            <hr>
            <p class="mb-0">Periksa email Anda untuk instruksi verifikasi. Jika Anda tidak menerima email, silakan
            <form id="resendVerificationForm" action="resend_verification" method="POST">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <button type="submit" class="btn btn-link">Kirim ulang verifikasi</button>
            </form>untuk mengirim ulang.</p>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#resendVerificationForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'resend_verification',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    alert(data.message);
                },
                error: function() {
                    alert("Terjadi kesalahan, silakan coba lagi.");
                }
            });
        });
    </script>
</body>

</html>
