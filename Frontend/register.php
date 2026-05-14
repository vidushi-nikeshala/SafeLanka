<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Register | SafeLanka</title>
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            background-color: #0b1629;
            color: #ffffff;
            overflow-x: hidden;
        }

        .main-box {
            display: flex;
            min-height: 100vh;
            background: radial-gradient(circle at 20% 30%, #001a33 0%, #050505 100%);
        }

        .top-bar {
            position: absolute;
            top: 25px;
            right: 40px;
            z-index: 1000;
        }

        .lang-btn {
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            user-select: none;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lang-btn:hover {
            color: #ffffff;
        }

        .lang-box {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 12px;
            background: #ffffff;
            border-radius: 6px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            min-width: 120px;
            overflow: hidden;
        }

        .lang-box a {
            display: block;
            color: #0b1629;
            text-decoration: none;
            padding: 12px 16px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .lang-box a:hover {
            background: rgba(230, 57, 70, 0.1);
            color: #e63946;
        }

        .lang-box.show {
            display: block;
        }

        .left-side {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8%;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
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
            z-index: 0;
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
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-top: 15px;
            font-weight: 500;
        }

        .right-side {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .register-box {
            width: 100%;
            max-width: 420px;
            background: rgba(13, 29, 56, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 45px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .register-box h2 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .register-box .sub-text {
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 35px;
            font-size: 0.95rem;
        }

        .error-msg {
            background: rgba(230, 57, 70, 0.1);
            border: 1px solid rgba(230, 57, 70, 0.4);
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
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .input-box input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .input-box input:focus {
            border-color: #e63946;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.15);
        }

        .register-btn {
            width: 100%;
            background: #e63946;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 15px;
        }

        .register-btn:hover {
            background: #c92a37;
        }

        .bottom-links {
            text-align: center;
            margin-top: 30px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .bottom-links a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid #e63946;   
            padding-bottom: 2px;
            transition: opacity 0.3s;
        }

        .bottom-links a:hover {
            opacity: 0.8;
        }

        @media (max-width: 900px) {
            .main-box     { flex-direction: column; }
            .left-side    { padding: 60px 20px; border-right: none; min-height: 30vh; }
            .right-side   { padding: 20px; align-items: flex-start; }
            .top-bar      { top: 20px; right: 20px; }
            .logo-text    { font-size: 3.5rem; }
        }
    </style>
</head>

<body>
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="top-bar">
        <div class="lang-btn" onclick="openLangMenu(event)">
            <i class="fa-solid fa-language"></i>
            &nbsp;<span id="lang-label">Language</span> ▾
            <div class="lang-box" id="langBox">
                <a href="#" onclick="setLanguage('en')">English</a>
                <a href="#" onclick="setLanguage('si')">සිංහල</a>
                <a href="#" onclick="setLanguage('ta')">தமிழ்</a>
            </div>
        </div>
    </div><br>

    <div class="main-box">

        <div class="left-side">
            <div class="logo-box">
                <div class="logo-text notranslate">Safe<span>Lanka</span></div>
                <div class="logo-sub">Together, Building a Safer Digital Sri Lanka.</div>
            </div>
        </div>

        <div class="right-side">
            <div class="register-box">

                <h2>Create Account</h2>
                <p class="sub-text">Sign up to report threats and support safer digital use in Sri Lanka.</p>

                <form action="../Backend/process_register.php" method="POST">

                    <div class="input-box">
                        <label>Full Name</label>
                        <input type="text" name="full_name" required placeholder="Your Full Name">
                    </div>

                    <div class="input-box">
                        <label>Email Address</label>
                        <input type="email" name="email" required placeholder="youremail@example.com">
                    </div>

                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" name="password" required minlength="6" placeholder="Min. 6 characters">
                    </div>

                    <div class="input-box">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" required minlength="6" placeholder="Confirm your password">
                    </div>

                    <button type="submit" class="register-btn">Register</button>

                </form>

                <div class="bottom-links">
                    Already have an account? <a href="login.php">Log in</a>
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
            if(myLabel) {
                myLabel.innerText = words[currentLang];
            }
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('service-worker.js')
                    .then(reg  => console.log('ServiceWorker registered'))
                    .catch(err => console.log('ServiceWorker failed'));
            });
        }
    </script>
</body>
</html>