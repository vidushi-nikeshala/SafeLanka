<?php
require_once '../Backend/db_config.php';
function defangIoC($type, $value) {
    if (empty($value)) return '';
    if ($type === 'url' || $type === 'email') {
        $value = str_ireplace('http://', 'hxxp://', $value);
        $value = str_ireplace('https://', 'hxxps://', $value);
        $value = str_replace('.', '[.]', $value);
    } elseif ($type === 'ip') {
        $value = str_replace('.', '[.]', $value);
    }
    return htmlspecialchars($value);
}

$cat_query = "SELECT category, COUNT(*) as count FROM reports WHERE status = 'Approved' GROUP BY category";
$cat_result = $conn->query($cat_query);

$categories = [];
$cat_counts = [];

if ($cat_result && $cat_result->num_rows > 0) {
    while($row = $cat_result->fetch_assoc()) {
        $categories[] = $row['category'];
        $cat_counts[] = $row['count'];
    }
}

// Get the latest 5 approved reports for the feed
$feed_query = "SELECT category, description, submitted_at, severity, target, admin_notes, ioc_url, ioc_ip, ioc_email FROM reports WHERE status = 'Approved' ORDER BY submitted_at DESC LIMIT 5";
$feed_result = $conn->query($feed_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <title>Public Threat Dashboard | SafeLanka</title>
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
            margin: 0 0 10px 0; 
        }

        .header-box h1 span { 
            color: #e63946; 
        }

        .header-box p { 
            color: rgba(255, 255, 255, 0.6); 
            font-size: 1.05rem; 
            max-width: 600px; 
            margin: 0 auto; 
            line-height: 1.5; 
        }

        .grid-box {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .card {
            background: rgba(13, 29, 56, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .card h3 {
            margin: 0 0 20px 0;
            font-size: 1.4rem;
            color: white;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
        }

        .chart-box {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .report-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list-item {
            padding: 20px 0;
            border-bottom: 1px dashed rgba(255,255,255,0.1);
        }

        .list-item:last-child { 
            border-bottom: none; 
        }
        
        .tag-group {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .cat-tag {
            background: rgba(230, 57, 70, 0.15);
            color: #ff9999;
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .level-tag {
            padding: 4px 10px;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 15px;
            text-transform: uppercase;
        }

        .level-crit { 
            background: rgba(230, 57, 70, 0.2);
             color: #ff4d4d; 
             border: 1px solid rgba(230,57,70,0.5); 
        }
        .level-high { 
            background: rgba(244, 162, 97, 0.2); 
            color: #f4a261; 
            border: 1px solid rgba(244,162,97,0.5); 
        }
        .level-med  { 
            background: rgba(233, 196, 106, 0.2); 
            color: #e9c46a; 
            border: 1px solid rgba(233,196,106,0.5); 
        }
        .level-low  { 
            background: rgba(42, 157, 143, 0.2); 
            color: #2a9d8f; 
            border: 1px solid rgba(42,157,143,0.5); 
        }

        .target-text {
            font-size: 0.85rem;
            color: #a8dadc;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .story-text {
            font-size: 0.95rem;
            color: rgba(255,255,255,0.9);
            margin: 0 0 12px 0;
            line-height: 1.6;
            background: rgba(0,0,0,0.2);
            padding: 12px;
            border-left: 3px solid #2a9d8f;
            border-radius: 4px;
        }

        .bad-links-box {
            background: rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 10px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #ccc;
            margin-bottom: 12px;
            font-family: 'Roboto Mono', monospace;
        }

        .bad-links-box strong { 
            color: #e63946; 
            font-family: 'Outfit', sans-serif; 
            display: block; 
            margin-bottom: 5px; 
        }

        .time-text {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
            margin: 0;
        }

        .empty-msg { 
            text-align: center; 
            color: rgba(255,255,255,0.5); 
            padding: 30px 0; 
        }

        @media (max-width: 900px) {
            .grid-box { grid-template-columns: 1fr; }
            .header-box h1 { font-size: 2.2rem; }
            .top { padding: 20px; flex-direction: column; gap: 15px; align-items: flex-start; }
            .lang-btn { align-self: flex-end; position: absolute; right: 20px; top: 20px; }
        }
    </style>
</head>
<body>
    
    <div id="google_translate_element" style="display: none;"></div>
    
    <div class="top">
        <div class="menu-links">
            <a href="homepage.php" class="menu-link"><i class="fa-solid fa-arrow-left"></i> Home</a>
            <a href="report.php" class="menu-link" style="color: #e63946;"><i class="fa-solid fa-triangle-exclamation"></i> Report a Threat</a>
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
            <h1 >Sri Lanka's Threat <span>Reports</span></h1>
            <p>Real-time visualization of verified cyber threats reported by the community across Sri Lanka.</p>
        </div>

        <div class="grid-box">
            
            <div class="card">
                <h3><i class="fa-solid fa-chart-pie" style="color: #e63946;"></i> Threat Distribution</h3>
                
                <?php if (empty($categories)): ?>
                    <div class="empty-msg">Not enough data to display chart yet.</div>
                <?php else: ?>
                    <div class="chart-box">
                        <canvas id="threatChart"></canvas>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3><i class="fa-solid fa-tower-broadcast" style="color: #e63946;"></i> Recent Verified Reports</h3>
                
                <?php if ($feed_result && $feed_result->num_rows > 0): ?>
                    <ul class="report-list">
                        <?php while($item = $feed_result->fetch_assoc()): ?>
                            
                            <?php
                                $sev_class = 'level-low';
                                $severity = !empty($item['severity']) ? $item['severity'] : 'Unknown';
                                if ($severity == 'Critical') $sev_class = 'level-crit';
                                elseif ($severity == 'High') $sev_class = 'level-high';
                                elseif ($severity == 'Medium') $sev_class = 'level-med';
                            ?>

                            <li class="list-item">
                                <div class="tag-group">
                                    <span class="cat-tag"><?php echo htmlspecialchars($item['category']); ?></span>
                                    <span class="level-tag <?php echo $sev_class; ?>"><?php echo htmlspecialchars($severity); ?></span>
                                </div>

                                <?php if(!empty($item['target'])): ?>
                                    <div class="target-text"><i class="fa-solid fa-crosshairs"></i> Target: <?php echo htmlspecialchars($item['target']); ?></div>
                                <?php endif; ?>

                                <?php if(!empty($item['admin_notes'])): ?>
                                    <p class="story-text"><i class="fa-solid fa-shield-check" style="color: #2a9d8f; margin-right: 5px;"></i><strong>Verified Intel:</strong> "<?php echo htmlspecialchars($item['admin_notes']); ?>"</p>
                                <?php else: ?>
                                    <p class="story-text">"<?php echo htmlspecialchars($item['description']); ?>"</p>
                                <?php endif; ?>

                                <?php if(!empty($item['ioc_url']) || !empty($item['ioc_ip']) || !empty($item['ioc_email'])): ?>
                                    <div class="bad-links-box">
                                        <strong><i class="fa-solid fa-link-slash"></i> Known Indicators:</strong>
                                        <?php if(!empty($item['ioc_url'])) echo 'URL: ' . defangIoC('url', $item['ioc_url']) . '<br>'; ?>
                                        <?php if(!empty($item['ioc_ip'])) echo 'IP: ' . defangIoC('ip', $item['ioc_ip']) . '<br>'; ?>
                                        <?php if(!empty($item['ioc_email'])) echo 'Email: ' . defangIoC('email', $item['ioc_email']) . '<br>'; ?>
                                    </div>
                                <?php endif; ?>

                                <p class="time-text"><i class="fa-regular fa-clock"></i> Reported: <?php echo date('M d, Y - H:i', strtotime($item['submitted_at'])); ?></p>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <div class="empty-msg">No verified reports available at the moment.</div>
                <?php endif; ?>
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



        let myLabels = <?php echo json_encode($categories); ?>;
        let myData = <?php echo json_encode($cat_counts); ?>;

        if (myLabels.length > 0) {
            let myCanvas = document.getElementById('threatChart').getContext('2d');
            
            Chart.defaults.color = 'rgba(255, 255, 255, 0.7)';
            Chart.defaults.font.family = "'Outfit', sans-serif";

            new Chart(myCanvas, {
                type: 'doughnut',
                data: {
                    labels: myLabels,
                    datasets: [{
                        data: myData,
                        backgroundColor: [
                            '#e63946', // Red
                            '#457b9d', // Muted Blue
                            '#1d3557', // Dark Blue
                            '#f4a261', // Orange
                            '#2a9d8f'  // Teal
                        ],
                        borderColor: '#0b1629', 
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 20, font: { size: 13 } }
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    </script>
</body>
</html>