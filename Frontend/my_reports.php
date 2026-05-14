<?php
session_start();
require_once '../Backend/db_config.php';

if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM reports WHERE user_id = ? ORDER BY submitted_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Reports | SafeLanka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background: #0b1629; 
            color: white; 
            padding: 40px; 
            margin: 0;
        }

        .main-box { 
            max-width: 800px; 
            margin: auto; 
        }

        .report-box { 
            background: rgba(255,255,255,0.05); 
            padding: 20px; 
            border-radius: 15px; 
            margin-bottom: 20px; 
            border: 1px solid rgba(255,255,255,0.1); 
        }

        .status { 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-size: 0.8rem; 
            font-weight: bold; 
            text-transform: uppercase; 
        }
        .Approved { 
            background: #2ecc71; 
            color: #fff; 
        }
        .Rejected { 
            background: #e74c3c; 
            color: #fff; 
        }
        .Pending { 
            background: #f1c40f; 
            color: #000; 
        }

        .admin-msg { 
            margin-top: 15px; 
            padding: 15px; 
            background: rgba(42, 157, 143, 0.1); 
            border-left: 4px solid #2a9d8f;
            border-radius: 4px; 
        }

        .admin-msg small { 
            color: #2a9d8f; 
            font-weight: bold; 
            display: block; 
            margin-bottom: 5px; 
        }
    </style>
</head>

<body>
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="main-box">
        <h2><i class="fa-solid fa-clock-rotate-left"></i> My Report History</h2>
        
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="report-box">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <strong><?= htmlspecialchars($row['category']) ?></strong>
                <span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span>
            </div>
            
            <p style="color:#ccc; font-size:0.9rem;">
                <?= htmlspecialchars($row['description']) ?>
            </p>

            <?php if(!empty($row['admin_notes'])): ?>
                <div class="admin-msg">
                    <small><i class="fa-solid fa-user-shield"></i> OFFICIAL RESPONSE</small>
                    <p style="margin:0; font-style:italic;">"<?= htmlspecialchars($row['admin_notes']) ?>"</p>
                </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
        
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