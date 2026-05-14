<?php
session_start();
require_once '../Backend/db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$query = "
    SELECT reports.*, users.full_name 
    FROM reports 
    LEFT JOIN users ON reports.user_id = users.user_id 
    WHERE reports.status = 'Pending' 
    ORDER BY reports.submitted_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | SafeLanka</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Outfit', sans-serif;
            color: white;
            background: radial-gradient(circle at 20% 30%, #001a33 0%, #050505 100%);
        }

        .header {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background: rgba(13, 29, 56, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header h2 {
            margin: 0;
            font-family: 'Roboto Mono', monospace;
            font-size: 1.5rem;
        }

        .header h2 span { 
            color: #e63946; 
        }

        .logout {
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 600;
            color: #e63946;
            background: rgba(230, 57, 70, 0.1);
            border: 1px solid rgba(230, 57, 70, 0.3);
            border-radius: 8px;
        }

        .main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
        }

        .card {
            padding: 25px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .data {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .category {
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ff9999;
            background: rgba(230, 57, 70, 0.15);
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 5px;
        }

        .badge {
            padding: 4px 10px;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        

        .critical {
            background: #e63946; color: white; 
        }

        .high { 
            background: #f4a261; color: #111; 
        }
        .medium { 
            background: #e9c46a; color: #111; 
        }
        .low { 
            background: #2a9d8f; color: white; 
        }

        .details {
            font-size: 0.85rem;
            color: #aaa;
            margin-bottom: 15px;
            display: grid;
            gap: 5px;
        }

        .details strong { 
            color: #ccc; 
        }

        .description {
            margin: 15px 0;
            padding: 15px;
            font-size: 0.95rem;
            line-height: 1.6;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            border-left: 3px solid #4a4a4a;
        }

        .threats {
            background: rgba(230, 57, 70, 0.05);
            border: 1px solid rgba(230, 57, 70, 0.2);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            font-family: 'Roboto Mono', monospace;
            font-size: 0.85rem;
        }

        .threats h4 {
            margin: 0 0 8px 0;
            color: #e63946;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .threat {
            margin-bottom: 4px;
            word-break: break-all;
        }
        
        .threat span { 
            color: #888; 
        }

        .preview {
            width: 100%;
            height: 180px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .reply { 
            margin-bottom: 15px; 
        }

        .label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #2a9d8f;
        }

        .input {
            width: 100%;
            margin-bottom: 10px;
            padding: 12px;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
            color: white;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .approve { background: #2a9d8f; }
        .reject  { background: #e63946; }
        
        .button:hover { 
            filter: brightness(1.1); 
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>

    <nav class="header notranslate">
        <h2>Safe<span>Lanka</span> Security</h2>
        <a href="../Backend/process_admin_logout.php" class="logout">Logout</a>
    </nav>

    <div class="main">
        <h3>Pending User Submitted Reports</h3>
        
        <div class="grid">
            <?php while($row = $result->fetch_assoc()): ?>
            
            <?php 
                $sev_class = 'low';
                if ($row['severity'] == 'Critical') {
                    $sev_class = 'critical';
                } elseif ($row['severity'] == 'High') {
                    $sev_class = 'high';
                } elseif ($row['severity'] == 'Medium') {
                    $sev_class = 'medium';
                }

                $display_name = !empty($row['full_name']) ? htmlspecialchars($row['full_name']) : 'User ID: ' . $row['user_id'];
                
                if ($row['is_anonyomus'] == 1) {
                    $reporter = '<i class="fa-solid fa-user-secret"></i> Anonymous';
                } else {
                    $reporter = '<i class="fa-solid fa-user"></i> ' . $display_name;
                }
            ?>

            <div class="card">
                
                <div class="data">
                    <div>
                        <div class="category"><?= htmlspecialchars($row['category']) ?></div>
                        <div class="badge <?= $sev_class ?>"><?= htmlspecialchars($row['severity']) ?></div>
                    </div>
                    <div style="text-align: right;">
                        <small style="color:#777; display:block;">Submitted: <?= date('M d, H:i', strtotime($row['submitted_at'])) ?></small>
                        <small style="color:#a8dadc; font-weight:600;"><?= $reporter ?></small>
                    </div>
                </div>

                <div class="details">
                    <div><strong>Target:</strong> <?= htmlspecialchars($row['target']) ?></div>
                    <div><strong>Incident Time:</strong> <?= !empty($row['incident_time']) ? date('M d, Y - H:i', strtotime($row['incident_time'])) : 'N/A' ?></div>
                </div>

                <?php if(!empty($row['ioc_url']) || !empty($row['ioc_ip']) || !empty($row['ioc_email'])): ?>
                <div class="threats">
                    <h4><i class="fa-solid fa-triangle-exclamation"></i> Indicators of Compromise</h4>
                    
                    <?php if(!empty($row['ioc_url'])): ?>
                        <div class="threat"><span>URL:</span> <?= htmlspecialchars($row['ioc_url']) ?></div>
                    <?php endif; ?>
                    
                    <?php if(!empty($row['ioc_ip'])): ?>
                        <div class="threat"><span>IP:</span> <?= htmlspecialchars($row['ioc_ip']) ?></div>
                    <?php endif; ?>
                    
                    <?php if(!empty($row['ioc_email'])): ?>
                        <div class="threat"><span>Email:</span> <?= htmlspecialchars($row['ioc_email']) ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="description">"<?= nl2br(htmlspecialchars($row['description'])) ?>"</div>

                <?php if(!empty($row['screenshot'])): ?>
                    <a href="../uploads/<?= htmlspecialchars($row['screenshot']) ?>" target="_blank">
                        <img src="../uploads/<?= htmlspecialchars($row['screenshot']) ?>" class="preview" alt="Evidence Screenshot">
                    </a>
                <?php endif; ?>

                <form action="../Backend/verify_report.php" method="POST">
                    <input type="hidden" name="report_id" value="<?= $row['report_id'] ?>">
                    
                    <div class="reply">
                        <label class="label">Verification Feedback</label>
                        <textarea name="admin_notes" class="input" rows="3" placeholder="Type your detailed thoughts here..." required></textarea>
                    </div>

                    <div class="actions">
                        <button type="submit" name="action" value="Reject" class="button reject">
                            <i class="fa-solid fa-xmark"></i> Reject
                        </button>
                        <button type="submit" name="action" value="Approve" class="button approve">
                            <i class="fa-solid fa-check"></i> Approve
                        </button>
                    </div>
                </form>
            </div>
            
            <?php endwhile; ?>
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