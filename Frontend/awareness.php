<?php

require_once '../Backend/db_config.php';

$trending_query = "
    SELECT category, COUNT(*) as report_count 
    FROM reports 
    WHERE status = 'Approved' AND submitted_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) 
    GROUP BY category 
    ORDER BY report_count DESC 
    LIMIT 1
";

$trending_result = $conn->query($trending_query);
$trending_category = "";

if ($trending_result && $trending_result->num_rows > 0) {
    $row = $trending_result->fetch_assoc();
    $trending_category = $row['category'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Stay Safe Online | SafeLanka</title>
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
            min-height: 100vh;
            background: radial-gradient(circle at 20% 30%, #001a33 0%, #050505 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .top {
            width: 100%;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .menu-links { 
            display: flex; 
            gap: 20px; 
        }

        .menu-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
        }

        .menu-link:hover { 
            color: white; 
        }

        .lang-btn {
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            position: relative;
            user-select: none;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .lang-btn:hover { 
            color: white; 
        }
        
        .lang-box {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
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
            font-size: 0.9rem;
            font-weight: 500;
            transition: background 0.2s, color 0.2s;
        }

        .lang-box a:hover { 
            background: rgba(230, 57, 70, 0.1); 
            color: #e63946; 
        }

        .lang-box.show { 
            display: block; 
        }

        .main-box {
            margin-top: 100px;
            width: 100%;
            max-width: 1200px;
            padding: 0 20px 60px 20px;
            box-sizing: border-box;
        }

        .header-box { 
            text-align: center; 
            margin-bottom: 50px; 
        }

        .header-box h1 { 
            font-family: 'Roboto Mono', monospace; 
            font-size: 3rem; 
            margin: 0 0 15px 0; 
            color: white; 
        }

        .header-box h1 span { 
            color: #e63946; 
        }

        .header-box p { 
            color: rgba(255, 255, 255, 0.7); 
            font-size: 1.1rem; 
            max-width: 600px; 
            margin: 0 auto; 
            line-height: 1.6; 
        }

        .grid-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .card {
            background: rgba(13, 29, 56, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 35px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
            position: relative; /* VIVA PREP: Keeps the hot badge attached to the card */
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(230, 57, 70, 0.4);
        }

        .hot-badge {
            position: absolute;
            top: -15px;
            right: -15px;
            background: #e63946;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(230, 57, 70, 0.5);
            animation: pulse 2s infinite; 
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: rgba(230, 57, 70, 0.1);
            color: #e63946;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8rem;
            margin-bottom: 25px;
        }

        .card h3 { 
            margin: 0 0 15px 0; 
            font-size: 1.4rem; 
            color: white; 
        }
        
        .card p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0 0 20px 0;
            flex-grow: 1; /* Pushes the safety tip and button to the bottom */
        }

        .tip-box {
            background: rgba(255, 255, 255, 0.03);
            border-left: 4px solid #e63946;
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 20px;
        }

        .tip-box strong { 
            display: block; 
            color: white; 
            font-size: 0.9rem; 
            margin-bottom: 5px; 
        }

        .tip-box span { 
            color: rgba(255, 255, 255, 0.6); 
            font-size: 0.85rem; 
            line-height: 1.5; 
        }

        .action-btn {
            display: block;
            width: 100%;
            padding: 12px 0;
            background: transparent;
            color: #e63946;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1px solid rgba(230, 57, 70, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .action-btn:hover {
            background: #e63946;
            color: white;
            border-color: #e63946;
        }

        @media (max-width: 768px) {
            .header-box h1 { 
                font-size: 2.2rem; 
            }
            .main-box { 
                margin-top: 80px; 
            }

            .top {
                flex-direction: column; 
                gap: 15px; 
                align-items: flex-start;
                flex-wrap: wrap; 
                padding: 15px;
                justify-content: center; 
            }
            
            .lang-btn { 
                align-self: flex-end; 
                position: absolute; 
                right: 20px; 
                top: 20px; 
            }

            .top a, .top .lang-btn {
                font-size: 0.85rem; 
            }
        }
    </style>
</head>
<body>
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="top">
        <div class="menu-links">
            <a href="homepage.php" class="menu-link"><i class="fa-solid fa-arrow-left"></i> Back to Homepage</a>
            <a href="dashboard.php" class="menu-link"><i class="fa-solid fa-chart-line"></i> Threat Dashboard</a>
        </div>
        <div class="lang-btn" onclick="openLangMenu(event)">
            <i class="fa-solid fa-language"></i>&nbsp;<span id="lang-label">Language</span> ▾
            <div class="lang-box" id="langBox">
                <a href="#" onclick="setLanguage('en')">English</a>
                <a href="#" onclick="setLanguage('si')">සිංහල</a>
                <a href="#" onclick="setLanguage('ta')">தமிழ்</a>
            </div>
        </div>
    </div>

    <div class="main-box">
        
        <div class="header-box">
            <h1>Cyber <span>Awareness</span></h1>
            <p>Knowledge is your best defense. Learn how to identify common online scams in Sri Lanka and protect your personal information.</p>
        </div>

        <div class="grid-box">
          
            <div class="card" <?php if($trending_category == 'Phishing') echo 'style="border-color: #e63946;"'; ?>>
                <?php if($trending_category == 'Phishing'): ?>
                    <div class="hot-badge"><i class="fa-solid fa-fire"></i> High Alert in LK</div>
                <?php endif; ?>
                
                <div class="icon-box"><i class="fa-solid fa-link"></i></div>
                <h3>Fake Links (Phishing)</h3>
                
        
                <p>Scammers send fake emails or SMS messages claiming you've won a prize. They use links that look real (e.g., typing <strong>bank0fceylon.com</strong> instead of bankofceylon.com) to steal passwords.</p>
                <div class="tip-box">
                    <strong>How to stay safe:</strong>
                    <span>Never click unexpected links. Inspect the URL carefully for spelling mistakes. Always type the official website directly into your browser.</span>
                </div>
                

                <a href="report.php?category=Phishing" class="action-btn"><i class="fa-solid fa-flag"></i> Report a Fake Link</a>
            </div>

   
            <div class="card" <?php if($trending_category == 'Social Engineering') echo 'style="border-color: #e63946;"'; ?>>
                <?php if($trending_category == 'Social Engineering'): ?>
                    <div class="hot-badge"><i class="fa-solid fa-fire"></i> High Alert in LK</div>
                <?php endif; ?>

                <div class="icon-box"><i class="fa-brands fa-whatsapp"></i></div>
                <h3>WhatsApp Scams</h3>
                <p>You might receive a message from a "friend" asking for emergency money, or a request to share a 6-digit verification code. Attackers hijack accounts this way to scam your contacts.</p>
                <div class="tip-box">
                    <strong>How to stay safe:</strong>
                    <span>Never share your 6-digit WhatsApp PIN. If a friend asks for money, call them directly on their normal phone number to verify their identity.</span>
                </div>
                <a href="report.php?category=Social Engineering" class="action-btn"><i class="fa-solid fa-flag"></i> Report WhatsApp Scam</a>
            </div>

            <div class="card" <?php if($trending_category == 'Online Fraud') echo 'style="border-color: #e63946;"'; ?>>
                <?php if($trending_category == 'Online Fraud'): ?>
                    <div class="hot-badge"><i class="fa-solid fa-fire"></i> High Alert in LK</div>
                <?php endif; ?>

                <div class="icon-box"><i class="fa-solid fa-store-slash"></i></div>
                <h3>Fake Online Stores</h3>
                
    
                <p>Scammers create fake Facebook pages selling items at unbelievably low prices. Once you pay via bank transfer, they block you. Often, these pages have comments disabled.</p>
                <div class="tip-box">
                    <strong>How to stay safe:</strong>
                    <span>Only buy from well-known platforms. Be highly suspicious of pages with disabled comments, very recent creation dates, or those demanding direct bank transfers.</span>
                </div>
                <a href="report.php?category=Online Fraud" class="action-btn"><i class="fa-solid fa-flag"></i> Report Fake Store</a>
            </div>

           
            <div class="card" <?php if($trending_category == 'Identity Theft') echo 'style="border-color: #e63946;"'; ?>>
                <?php if($trending_category == 'Identity Theft'): ?>
                    <div class="hot-badge"><i class="fa-solid fa-fire"></i> High Alert in LK</div>
                <?php endif; ?>

                <div class="icon-box"><i class="fa-solid fa-user-secret"></i></div>
                <h3>Fake Profiles (Identity Theft)</h3>
                <p>Someone steals your photos and creates a fake social media account pretending to be you. They may try to scam your contacts or damage your reputation.</p>
                <div class="tip-box">
                    <strong>How to stay safe:</strong>
                    <span>Set social media profiles to "Private" so strangers cannot download photos. Do a reverse-image search on suspicious friend requests.</span>
                </div>
                <a href="report.php?category=Identity Theft" class="action-btn"><i class="fa-solid fa-flag"></i> Report Fake Profile</a>
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