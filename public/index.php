<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with reCAPTCHA</title>
    <style>
        /* Reset CSS */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Style for body */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }

        /* Style for form container */
        .form-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .form-container h2 {
            margin-bottom: 1rem;
            color: #333;
        }

        .form-container p {
            margin-bottom: 2rem;
            color: #666;
        }

        /* Style for reCAPTCHA */
        .g-recaptcha {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        /* Style for submit button */
        .submit-btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Verifikasikan Bahwa Anda Bukan Robot</h2>
        <p>Lengkapi verifikasi di bawah ini untuk melanjutkan.</p>
        <form action="./handler/submit.php" method="post">
            <div class="g-recaptcha" data-sitekey="6Le9C34qAAAAANZmCbHrVfWTkO48bIHWrKBaBQ4V"></div>
            <button type="submit" class="submit-btn">Kirim</button>
        </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
