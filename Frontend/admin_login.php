<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | SafeLanka</title>
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

        .wrapper {
            display: flex;
            min-height: 100vh;
            background: radial-gradient(circle at 80% 20%, #001a33 0%, #020813 100%);
        }

        .left {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 8%;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(11, 22, 41, 0.8);
            overflow: hidden; 
        }

        .left::before {
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
            z-index: 0;
        }

        .icon {
            font-size: 5rem;
            color: #e63946;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .brand {
            text-align: center;
            z-index: 1; /* Keeps text above the watermark */
        }

        .title {
            font-family: 'Roboto Mono', monospace;
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            letter-spacing: 2px;
            margin: 0;
            line-height: 1;
        }

        .title span { 
            color: #e63946; 
        }

        .subtitle {
            font-size: 1.1rem;
            color: #e63946;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-top: 15px;
            font-weight: 600;
        }
        
        .notice {
            margin-top: 30px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
            max-width: 300px;
            text-align: center;
            line-height: 1.5;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            z-index: 1; /* Keeps text above the watermark */
        }

        .right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 45px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .login h2 { 
            margin-top: 0; 
            margin-bottom: 5px; 
            font-size: 1.8rem; 
            font-weight: 600;
        }

        .login p {
            color: rgba(255,255,255,0.5); 
            margin-bottom: 30px; 
            font-size: 0.95rem;
        }
        
        .field { 
            margin-bottom: 22px; 
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }
        
        .field input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: white;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .field input:focus {
            border-color: #e63946;
            background: rgba(0, 0, 0, 0.4);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.15);
        }

        .button {
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
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .button:hover { 
            background: #c92a37; 
        }

        .link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .link:hover { 
            color: white; 
        }

        
        @media (max-width: 900px) {
            .wrapper { flex-direction: column; }
            .left { padding: 40px 20px; border-right: none; min-height: auto; }
            .right { padding: 20px; align-items: flex-start; }
            .icon { font-size: 3.5rem; }
            .title { font-size: 2.8rem; }
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>
    <div class="wrapper">
        
        <div class="left">
            <div class="brand">
                <div class="title notranslate">Safe<span>Lanka</span></div>
                <div class="subtitle">Admin Portal</div>
            </div>
            <div class="notice">
                RESTRICTED AREA: This system is for authorized SafeLanka administrators only.
            </div>
        </div>

        <div class="right">
            <div class="login">
                <h2>Admin Login</h2>
                <p>Enter your credentials to access the dashboard.</p>
                
                <form action="../Backend/process_admin_login.php" method="POST">
                    <div class="field">
                        <label for="username">Admin Username</label>
                        <input type="text" id="username" name="username" required placeholder="Enter admin username">
                    </div>
                    
                    <div class="field">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter password">
                    </div>
                    
                    <button type="submit" class="button">
                        <i class="fa-solid fa-lock"></i> Login
                    </button>
                </form>
                
                <a href="homepage.php" class="link"><i class="fa-solid fa-arrow-left"></i> Return to Public Site</a>
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

        window.onclick = function(event) {
            if (!event.target.closest('.lang-btn')) {
                let box = document.getElementById("langBox");
                if (box && box.classList.contains('show')) { 
                    box.classList.remove('show'); 
                }
            }
        }

        function setLanguage(langCode) { 
            document.cookie = "googtrans=/en/" + langCode + "; path=/";
            location.reload();
        }

        // Read language cookie when page loads
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