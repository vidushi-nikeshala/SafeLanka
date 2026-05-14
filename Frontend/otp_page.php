<?php 
session_start(); 

if(!isset($_SESSION['temp_user'])) {
    header("Location: register.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Email | SafeLanka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body { 
            margin: 0; 
            font-family: 'Outfit', sans-serif; 
            background: radial-gradient(circle at 20% 30%, #001a33 0%, #050505 100%); 
            color: white; 
            display: flex; 
            justify-content: center;
            align-items: center; 
            height: 100vh; 
        }

        .verify-box { 
            background: rgba(13, 29, 56, 0.6); 
            backdrop-filter: blur(15px);
            padding: 40px; 
            border-radius: 12px; 
            text-align: center; 
            border: 1px solid rgba(255,255,255,0.08); 
            width: 100%; 
            max-width: 400px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.4); 
        }

        .verify-box h2 { 
            margin-top: 0; 
            color: white; 
        }

        .verify-box p { 
            color: rgba(255,255,255,0.6); 
            font-size: 0.95rem; 
            margin-bottom: 25px; 
        }

        .verify-box input { 
            font-size: 2rem; 
            letter-spacing: 12px; 
            text-align: center; 
            width: 180px; 
            padding: 12px; 
            border-radius: 8px; 
            border: 2px solid rgba(255,255,255,0.1); 
            background: rgba(0,0,0,0.3); 
            color: white; 
            margin-bottom: 25px; 
            outline: none; 
            font-family: monospace; 
            transition: 0.3s; 
        }

        .verify-box input:focus { 
            border-color: #e63946; 
            box-shadow: 0 0 10px rgba(230,57,70,0.2); 
        }

        .verify-box button { 
            background: #e63946; 
            color: white; 
            border: none; 
            padding: 16px; 
            font-size: 1.05rem; 
            border-radius: 8px; 
            cursor: pointer; 
            width: 100%; 
            font-weight: 600; 
            transition: 0.3s; 
        }

        .verify-box button:hover { 
            background: #c92a37; 
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>

    <div class="verify-box">
        <h2>Verify Your Email</h2>
        <p>Enter the 4-digit code sent to <strong><?php echo htmlspecialchars($_SESSION['temp_user']['email']); ?></strong></p>

        <form action="../Backend/verify_otp.php" method="POST">
            <input type="text" name="user_otp" maxlength="4" required autocomplete="off" placeholder="••••">
            <button type="submit">Verify & Create Account</button>
        </form>
    </div>

</body>
</html>