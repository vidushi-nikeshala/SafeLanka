<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="theme-color" content="#0b1629">
    <title>Forgot Password | SafeLanka</title>

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

        .reset-box {
            background: rgba(13, 29, 56, 0.6);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .reset-box h2 {
            margin-top: 0;
        }

        .reset-box p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        .reset-box input {
            width: 100%;
            box-sizing: border-box;
            padding: 14px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: white;
            outline: none;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
        }

        .reset-box input:focus {
            border-color: #e63946;
        }

        .reset-box button {
            width: 100%;
            padding: 15px;
            background: #e63946;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
        }

        .reset-box button:hover {
            background: #c92a37;
        }

        .reset-box a {
            display: block;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="reset-box">
        <h2>Reset Password</h2>
        <p>Enter your registered email address.</p>

        <form action="../Backend/process_forgot.php" method="POST">
            <input type="email" name="email" required placeholder="youremail@gmail.com">
            <button type="submit">Find My Account</button>
        </form>

        <a href="login.php"><b>Back to Login</b></a>
    </div>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', 
                includedLanguages: 'en,si,ta', 
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <script>
        function setLanguage(langCode) {
            document.cookie = "googtrans=/en/" + langCode + "; path=/";
            location.reload();
        }

        window.addEventListener('DOMContentLoaded', () => {
            let currentLang = 'en';
            let myCookies = document.cookie;

            if (myCookies.includes('googtrans=/en/si')) {
                currentLang = 'si';
            }
            if (myCookies.includes('googtrans=/en/ta')) {
                currentLang = 'ta';
            }
            
            let words = { 
                en: 'Language', 
                si: 'සිංහල', 
                ta: 'தமிழ்' 
            };
            
            let myLabel = document.getElementById('lang-label');
            if(myLabel) {
                myLabel.innerText = words[currentLang];
            }
        });
    </script>
</body>
</html>