<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Login | SafeLanka</title>
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * { 
            box-sizing: border-box; 
        }

        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 20% 30%, #001a33 0%, #050505 100%);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .top {
            position: absolute;
            top: 0; 
            left: 0; 
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            z-index: 1000;
        }

        .back-link {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: color 0.2s;
        }

        .back-link:hover { 
            color: white; 
        }

        .lang-btn {
            cursor: pointer;
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            position: relative;
            user-select: none;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: color 0.2s;
        }

        .lang-btn:hover { 
            color: white; 
        }

        .lang-box {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            min-width: 130px;
            overflow: hidden;
        }

        .lang-box a {
            display: block;
            color: #0b1629;
            text-decoration: none;
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: background 0.2s;
        }

        .lang-box a:hover { 
            background: rgba(230,57,70,0.1);
            color: #e63946; 
        }

        .lang-box.show { 
            display: block; 
        }

        .main-box {
            display: flex;
            min-height: 100vh;
        }

        .left-side {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8%;
            border-right: 1px solid rgba(255,255,255,0.05);
            overflow: hidden;
        }

        .left-side::before {
            content: '';
            position: absolute;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%; 
            height: 80%;
            background-image: url('images/png.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.04;
            pointer-events: none;
        }

        .logo-box { 
            position: relative; 
            z-index: 1; 
            text-align: center; 
        }

        .logo-text {
            font-family: 'Roboto Mono', monospace;
            font-size: 4.5rem;
            font-weight: 700;
            color: white;
            letter-spacing: 2px;
            margin: 0;
            line-height: 1;
        }

        .logo-text span { 
            color: #e63946; 
        }

        .logo-sub {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.45);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-top: 14px;
        }

        .info-list { 
            margin-top: 50px; 
            display: flex; 
            flex-direction: column; 
            gap: 16px; 
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.55);
            font-size: 0.9rem;
        }

        .info-item i {
            width: 36px; 
            height: 36px;
            background: rgba(230,57,70,0.12);
            border-radius: 50%;
            display: flex; 
            align-items: center; 
            justify-content: center;
            color: #e63946;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .right-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 100px 40px 40px;
        }

        .login-box {
            width: 100%;
            max-width: 430px;
            background: rgba(13, 29, 56, 0.65);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 45px 40px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
        }

        .login-box h2 { 
            margin: 0 0 6px; 
            font-size: 1.9rem; 
            font-weight: 700; 
        }

        .login-box > p { 
            color: rgba(255,255,255,0.5); 
            margin: 0 0 28px; 
            font-size: 0.95rem; 
        }

        .error-msg {
            background: rgba(230,57,70,0.1);
            border: 1px solid rgba(230,57,70,0.4);
            color: #ffb3b3;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .input-box { 
            margin-bottom: 22px; 
        }

        .input-box label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .hint {
            display: block;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.35);
            margin-bottom: 8px;
            margin-top: -4px;
        }

        .input-inner { 
            position: relative; 
        }

        .input-inner i.icon {
            position: absolute;
            left: 14px; 
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.25);
            font-size: 0.95rem;
            pointer-events: none;
        }

        .input-box input {
            width: 100%;
            padding: 14px 44px 14px 40px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
        }

        .input-box input:focus {
            border-color: #e63946;
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 3px rgba(230,57,70,0.15);
        }

        .show-pw {
            position: absolute;
            right: 14px; 
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255,255,255,0.3);
            font-size: 0.9rem;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
        }

        .show-pw:hover { 
            color: rgba(255,255,255,0.7); 
        }

        .login-btn {
            width: 100%;
            background: #e63946;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 6px;
            letter-spacing: 0.3px;
        }

        .login-btn:hover  { background: #c92a37; }
        .login-btn:active { transform: scale(0.99); }

        .bottom-links {
            text-align: center;
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
        }

        .bottom-links a { 
            color: white; 
            text-decoration: none; 
            font-weight: 600; 
            transition: opacity 0.2s; 
        }
        
        .bottom-links a:hover { 
            opacity: 0.75; 
        }

        .bottom-links .red-link { 
            color: #e63946; 
        }

        .line-or {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0;
            color: rgba(255,255,255,0.2);
            font-size: 0.8rem;
        }

        .line-or::before, .line-or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.1);
        }

        @media (max-width: 900px) {
            .main-box { flex-direction: column; }
            .left-side { padding: 100px 20px 40px; border-right: none; min-height: auto; }
            .right-side { padding: 20px 20px 40px; align-items: flex-start; }
            .login-box { padding: 30px 24px; }
            .logo-text { font-size: 3rem; }
            .info-list { display: none; }
            .top { padding: 18px 20px; }
        }
    </style>
</head>

<body>
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="top">
        <a href="homepage.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Homepage
        </a>

        <div class="lang-btn" onclick="openLangMenu(event)">
            <i class="fa-solid fa-language"></i>
            &nbsp;<span id="lang-label">Language</span> ▾
            <div class="lang-box" id="langBox">
                <a href="#" onclick="pickLanguage('en')">English</a>
                <a href="#" onclick="pickLanguage('si')">සිංහල</a>
                <a href="#" onclick="pickLanguage('ta')">தமிழ்</a>
            </div>
        </div>
    </div>

    <div class="main-box">
        <div class="left-side">
            <div class="logo-box">
                <div class="logo-text notranslate">Safe<span>Lanka</span></div>
                <div class="logo-sub">Together, Building a Safer Digital Sri Lanka.</div>
            </div>
            <div class="info-list">
                <div class="info-item">
                    <i class="fas fa-lock"></i>
                    <span>Your information is kept private and secure</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user-shield"></i>
                    <span>Reports can be made anonymously</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-headset"></i>
                    <span>Need help? Call us: <strong style="color:white">+94 11 234 5678</strong></span>
                </div>
            </div>
        </div>

        <div class="right-side">
            <div class="login-box">

                <h2>Welcome Back</h2>
                <p>Sign in to your SafeLanka account</p>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="error-msg">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="../Backend/process_login.php" method="POST">

                    <div class="input-box">
                        <label for="email">Email Address</label>
                        <span class="hint">The email you used when you registered</span>
                        <div class="input-inner">
                            <i class="fas fa-envelope icon"></i>
                            <input type="email" id="email" name="email" required placeholder="e.g. youremail@gmail.com" autocomplete="email">
                        </div>
                    </div>

                    <div class="input-box">
                        <label for="password">Password</label>
                        <span class="hint">Enter the password you created when you signed up</span>
                        <div class="input-inner">
                            <i class="fas fa-key icon"></i>
                            <input type="password" id="password" name="password" required placeholder="Enter your password" autocomplete="current-password">
                            <button type="button" class="show-pw" onclick="showHidePassword()" aria-label="Show or hide password">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>&nbsp; Login
                    </button>

                </form>

                <div class="line-or">or</div>

                <div class="bottom-links">
                    <span>Don't have an account?
                        <a href="register.php" class="red-link">Create Account</a>
                    </span>
                    <a href="forgot_password.php" style="font-size:0.85rem; color:rgba(255,255,255,0.35);">
                        <i class="fas fa-question-circle"></i>&nbsp;Forgot your password?
                    </a>
                </div>

            </div>
        </div>

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
        function showHidePassword() {
            let myInput = document.getElementById('password');
            let myIcon = document.getElementById('eyeIcon');
            let isShowing = myInput.type === 'text';
            
            if (isShowing) {
                myInput.type = 'password';
                myIcon.className = 'fas fa-eye-slash';
            } else {
                myInput.type = 'text';
                myIcon.className = 'fas fa-eye';
            }
        }

        function openLangMenu(event) {
            event.stopPropagation();
            let box = document.getElementById("langBox");
            if (box.classList.contains("show")) {
                box.classList.remove("show");
            } else {
                box.classList.add("show");
            }
        }

        window.onclick = function (event) {
            if (!event.target.closest('.lang-btn')) {
                let box = document.getElementById("langBox");
                if (box) {
                    box.classList.remove('show');
                }
            }
        };

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
            if (myLabel) {
                myLabel.innerText = words[currentLang];
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('service-worker.js')
                    .catch(err => console.warn('ServiceWorker failed:', err));
            });
        }
    </script>
</body>
</html>