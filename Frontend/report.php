<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please login first to submit a report.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Report a Threat | SafeLanka</title>
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

        .top-bar {
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

        .back-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
        }

        .back-link:hover { 
            color: white; 
        }

        .lang-btn {
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            position: relative;
            user-select: none;
            transition: color 0.3s;
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

        .form-wrap {
            margin-top: 100px;
            margin-bottom: 40px;
            width: 100%;
            max-width: 650px;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .report-box {
            background: rgba(13, 29, 56, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-title h2 {
            margin: 0 0 10px 0;
            font-size: 2.2rem;
            font-family: 'Roboto Mono', monospace;
        }

        .page-title h2 span { 
            color: #e63946; 
        }

        .page-title p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            margin: 0;
            line-height: 1.5;
        }

        .input-group { 
            margin-bottom: 20px; 
        }
        
        .two-cols {
            display: flex;
            gap: 15px;
        }

        .two-cols .input-group {
            flex: 1;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .hint-text {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            display: block;
            margin-bottom: 8px;
        }

        .basic-input {
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
            color-scheme: dark;
        }

        .basic-input:focus {
            border-color: #e63946;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.15);
        }

        .add-space { 
            margin-bottom: 10px; 
        }

        select.basic-input {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23FFFFFF%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 15px top 50%;
            background-size: 12px auto;
        }

        select.basic-input option {
            background-color: #0b1629;
            color: white;
        }

        .switch-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.02);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 25px;
        }
        
        .switch-title {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .toggle-btn {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
        }

        .toggle-btn input { 
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; 
            left: 0; 
            right: 0; 
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.2);
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider { 
            background-color: #e63946; 
        }
        
        input:checked + .slider:before { 
            transform: translateX(24px); 
        }

        .upload-box {
            position: relative;
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-box:hover {
            border-color: #e63946;
            background: rgba(230, 57, 70, 0.05);
        }

        .upload-box input[type="file"] {
            position: absolute;
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-info i {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 10px;
        }

        .upload-info p {
            margin: 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .file-name {
            display: block;
            margin-top: 10px;
            font-size: 0.85rem;
            color: #e63946;
            word-break: break-all;
        }

        .submit-btn {
            width: 100%;
            background: #e63946;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover { 
            background: #c92a37; 
        }

        @media (max-width: 768px) {
            html, body {
                width: 100% !important;
                overflow-x: hidden !important; 
                margin: 0 !important;
                padding: 0 !important;
            }

            .form-wrap {
                width: 100% !important;
                max-width: 100% !important;
                padding: 20px 15px !important; 
                box-sizing: border-box !important;
                display: block !important; 
            }

            .report-box {
                width: 100% !important;
                max-width: 100% !important;
                padding: 30px 20px !important;
                margin: 0 auto !important;
                box-sizing: border-box !important;
            }

            .input-group input, 
            .input-group select, 
            .input-group textarea,
            .two-cols {
                width: 100% !important;
                max-width: 100% !important;
                box-sizing: border-box !important;
                flex-direction: column !important; 
            }

            input[type="date"],
            input[type="datetime-local"],
            input[type="time"] {
                width: 100% !important;
                box-sizing: border-box !important;
                -webkit-appearance: none !important; 
                appearance: none !important;
                display: block !important;
                padding: 15px 10px !important; 
                margin: 0 !important;
                font-size: 16px !important; 
                background-color: rgba(255, 255, 255, 0.04) !important; 
                color: white !important;
            }
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="top-bar">
        <a href="homepage.php" class="back-link">
            <i class="fa-solid fa-arrow-left"></i> Back to Homepage
        </a>
        
        <div class="lang-btn" onclick="toggleLanguageMenu(event)">
            <i class="fa-solid fa-language"></i>&nbsp;<span id="lang-label">Language</span> ▾
            <div class="lang-box" id="lang-dropdown">
                <a href="#" onclick="setLanguage('en')">English</a>
                <a href="#" onclick="setLanguage('si')">සිංහල</a>
                <a href="#" onclick="setLanguage('ta')">தமிழ்</a>
            </div>
        </div>
    </div>

    <div class="form-wrap">
        <div class="report-box">
            
            <div class="page-title">
                <h2>Report a <span>Threat</span></h2>
                <p>Describe the incident so our team can review and investigate it. Please include as much detail as possible.</p>
            </div>

            <form action="../Backend/process_report.php" method="POST">
                
                <div class="switch-box">
                    <span class="switch-title">Submit Anonymously? <br>
                        <small style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">Hide my identity from public reports</small>
                    </span>
                    <label class="toggle-btn">
                        <input type="checkbox" name="is_anonymous" value="1">
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="two-cols">
                    <div class="input-group">
                        <label for="when-it-happened">When did this happen?</label>
                        <input type="datetime-local" name="incident_time" id="when-it-happened" class="basic-input" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="how-bad">Severity Level</label>
                        <select name="severity" id="how-bad" class="basic-input" required>
                            <option value="" disabled selected>Select severity...</option>
                            <option value="Low">Low (Spam, Minor attempt)</option>
                            <option value="Medium">Medium (Targeted Phishing)</option>
                            <option value="High">High (Account Hacked, Financial Fraud)</option>
                            <option value="Critical">Critical (Ransomware, Server Breach)</option>
                        </select>
                    </div>
                </div>

                <div class="input-group">
                    <label for="threat-type">What type of threat are you reporting?</label>
                    <select name="category" id="threat-type" class="basic-input" required>
                        <option value="" disabled selected>Select a category...</option>
                        <option value="Phishing">Fake Link / Phishing</option>
                        <option value="Online Fraud">Online Scam / Fraud</option>
                        <option value="Identity Theft">Fake Profile / Identity Theft</option>
                        <option value="Social Engineering">Suspicious WhatsApp/SMS Message</option>
                        <option value="Malware">Virus / Malware</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="what-got-hit">What was targeted?</label>
                    <select name="target" id="what-got-hit" class="basic-input" required>
                        <option value="" disabled selected>Select the target...</option>
                        <option value="Personal Email/Social">Personal Account (Social Media, Email)</option>
                        <option value="Banking/Financial">Financial / Banking Information</option>
                        <option value="Corporate Infrastructure">Company / Business Network</option>
                        <option value="Mobile Device">Mobile Phone / Tablet</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Indicators of Compromise (IoCs)</label>
                    <span class="hint-text">Provide any technical details you have (Optional)</span>
                    <input type="text" name="ioc_url" class="basic-input add-space" placeholder="Suspicious URL or Domain (e.g., fake-bank.com)">
                    <input type="text" name="ioc_ip" class="basic-input add-space" placeholder="Suspicious IP Address (e.g., 192.168.1.100)">
                    <input type="email" name="ioc_email" class="basic-input" placeholder="Attacker's Email Address">
                </div>

                <div class="input-group">
                    <label for="story-box">What happened?</label>
                    <textarea name="description" id="story-box" class="basic-input" rows="5" placeholder="Please describe the incident in simple words..." required></textarea>
                </div>

                <div class="input-group">
                    <label>Attach Evidence (Optional but recommended)</label>
                    <div class="upload-box">
                        <div class="upload-info">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <p>Click or drag a screenshot here</p>
                            <span class="file-name" id="shown-file-name"></span>
                        </div>
                        <input type="file" id="pic-upload" accept="image/png, image/jpeg, image/jpg">
                    </div>
                </div>

                <input type="hidden" name="screenshot_base64" id="hidden-pic-data">

                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-shield-halved"></i> Submit Report securely
                </button>
            </form>

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
        function toggleLanguageMenu(event) {
            event.stopPropagation();
            document.getElementById("lang-dropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.lang-btn') && !event.target.matches('.lang-btn *')) {
                let menu = document.getElementById("lang-dropdown");
                if (menu && menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            }
        }

        document.getElementById('pic-upload').addEventListener('change', function(event) {
            let myFile = event.target.files[0];
            let nameText = document.getElementById('shown-file-name');
            let hiddenData = document.getElementById('hidden-pic-data');

            if (myFile) {
                nameText.textContent = "Selected: " + myFile.name;

                let reader = new FileReader();
                reader.onloadend = function() {
                    hiddenData.value = reader.result;
                };

                reader.readAsDataURL(myFile);
            } else {
                nameText.textContent = "";
                hiddenData.value = "";
            }
        });
        window.onload = function() {
            let rightNow = new Date();
            rightNow.setMinutes(rightNow.getMinutes() - rightNow.getTimezoneOffset());
            document.getElementById('when-it-happened').value = rightNow.toISOString().slice(0,16);
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
    </script>
</body>
</html>