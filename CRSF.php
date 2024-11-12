<?php
session_start();

// CSRF token oluşturma
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CSRF token doğrulama
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Token geçerli, işlemleri gerçekleştir
        $message = "CSRF token doğrulandı!";
    } else {
        // Token geçersiz, hata mesajı göster
        $message = "Geçersiz CSRF token!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Token Örneği</title>
    <style>
        /* Basic Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f0f2f5;
        }

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .container h1 {
            color: #333;
            margin-bottom: 15px;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            color: white;
            background-color: #4caf50; /* Başarılı mesaj */
            border-radius: 5px;
            display: <?php echo isset($message) ? 'block' : 'none'; ?>;
        }

        .error {
            background-color: #f44336; /* Hata mesajı */
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            color: #555;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>CSRF Token Örneği</h1>
    
    <?php if (isset($message)): ?>
        <div class="message <?php echo isset($message) && $message == 'Geçersiz CSRF token!' ? 'error' : ''; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Şifre:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <button type="submit" class="btn">Gönder</button>
    </form>
</div>

</body>
</html>
