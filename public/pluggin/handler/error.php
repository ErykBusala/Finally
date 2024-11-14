<?php
session_start();
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "Terjadi kesalahan yang tidak diketahui.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - MUA MAKEUP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }
        .error-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            text-align: center;
        }
        .error-container h1 {
            color: #d46e85;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .error-container p {
            font-size: 16px;
            color: #666;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #d46e85;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #c45a72;
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1>Oops! Terjadi Kesalahan</h1>
    <p><?php echo $error_message; ?></p>
    <button class="back-button" onclick="window.history.back();">Kembali</button>
</div>

</body>
</html>
