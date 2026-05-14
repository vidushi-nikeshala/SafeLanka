<?php 
session_start(); 

// Check if they are allowed to be here
if(!isset($_SESSION['reset_email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Create New Password | SafeLanka</title>
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

        .pw-box { 
            background: rgba(13, 29, 56, 0.6); 
            backdrop-filter: blur(15px); 
            padding: 40px; 
            border-radius: 12px; 
            border: 1px solid rgba(255,255,255,0.08); 
            width: 100%; 
            max-width: 400px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.4); 
        }

        .pw-box input { 
            width: 100%; 
            box-sizing: border-box; 
            padding: 14px; 
            border-radius: 8px; 
            border: 1px solid rgba(255,255,255,0.1); 
            background: rgba(255,255,255,0.05); 
            color: white; 
            margin-bottom: 20px; 
            outline: none; 
            font-family: 'Outfit', sans-serif; 
            font-size: 1rem; 
        }

        .pw-box input:focus { 
            border-color: #2a9d8f; 
        }

        .pw-box button { 
            background: #2a9d8f; 
            color: white; 
            border: none; 
            padding: 15px; 
            font-size: 1.05rem; 
            border-radius: 8px; 
            cursor: pointer; 
            width: 100%; 
            font-weight: 600; 
        }

        .title-text {
            text-align: center; 
            margin-top: 0;
        }

        .sub-text {
            text-align: center; 
            color: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>

    <div class="pw-box">
        <h2 class="title-text">New Password</h2>
        
        <p class="sub-text">
            Updating password for<br>
            <strong><?php echo htmlspecialchars($_SESSION['reset_email']); ?></strong>
        </p>
        
        <form action="../Backend/process_new_password.php" method="POST">
            <input type="password" name="new_pass" required placeholder="New Password (min 6 chars)" minlength="6">
            <input type="password" name="confirm_pass" required placeholder="Confirm New Password" minlength="6">
            <button type="submit">Update Password</button>
        </form>
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