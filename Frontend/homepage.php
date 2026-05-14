<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']);

$userName = $isLoggedIn ? htmlspecialchars($_SESSION['user_name']) : '';

$initials = '';
if ($isLoggedIn && $userName !== '') {
    $words = explode(' ', trim($userName));
    $initials = strtoupper(substr($words[0], 0, 1)); 
    if (count($words) > 1) {
        $initials .= strtoupper(substr(end($words), 0, 1)); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SafeLanka.lk — Report Cyber Threats</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <meta name="theme-color" content="#0b1629">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="manifest" href="manifest.json">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="homepage.css">
</head>

<body>

    <div id="google_translate_element" style="display: none;"></div>

    <nav class="navbar" id="navbar">

        <a href="homepage.php" class="nav-logo notranslate">
            <div class="logo">
                <img src="images/png.png" alt="SafeLanka Logo">
            </div>
            <span class="name">Safe<span>Lanka</span></span>
        </a>

        <button class="menu-button" id="menuButton" onclick="toggleNav()" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>

        <div class="nav-menu" id="navMenu">
            <a href="home.php" class="nav-item active">Home</a>
            <a href="report.php" class="nav-item">Report a Threat</a>
            <a href="dashboard.php" class="nav-item">Dashboard</a>
            <a href="awareness.php" class="nav-item">Stay Safe</a>

            <div class="language notranslate" onclick="toggleLanguageMenu(event)">
                <i class="fa-solid fa-language"></i>&nbsp;<span id="lang-label">Language</span> ▾
                <div class="language-menu" id="languageMenu">
                    <a href="#" onclick="setLanguage('en')">English</a>
                    <a href="#" onclick="setLanguage('si')">සිංහල</a>
                    <a href="#" onclick="setLanguage('ta')">தமிழ்</a>
                </div>
            </div>

            <?php if (!$isLoggedIn): ?>
                <a href="login.php" class="nav-login-btn">Login</a>
                <a href="register.php" class="nav-register-btn">Register</a>
            <?php else: ?>
                <div class="user-avatar-wrapper notranslate" id="userAvatarWrapper" onclick="toggleUserMenu(event)">
                    <div class="user-avatar" title="<?= $userName ?>">
                        <?= $initials ?>
                    </div>

                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-avatar notranslate notranslate"><?= $initials ?></div>
                            <div>
                                <div class="user-dropdown-name notranslate"><?= $userName ?></div>
                                <div class="user-dropdown-label">Logged in</div>
                            </div>
                        </div>

                        <div class="user-dropdown-divider"></div>

                        <a href="my_reports.php" class="user-dropdown-item">
                            <i class="fa-solid fa-clock-rotate-left"></i> My Reports
                        </a>

                        <div class="user-dropdown-divider"></div>

                        <a href="logout.php" class="user-dropdown-item">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title notranslate">Safe<span>Lanka</span></h1>
                <h2 class="hero-subtitle">Together, Building a Safer Digital Sri Lanka.</h2>
                <p class="hero-p">
                    Are you being scammed online? Getting fake messages?
                    Seen a suspicious website? Report it here — simply, safely.
                </p>
                <div class="hero-btns">
                    <a href="report.php" class="btn-primary-red">Report a Threat</a>
                    <a href="awareness.php" class="btn-outline">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="hero-image-block">
                <img src="images/logo2.png" alt="Cyber Security Visual" class="floating-img">
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <span class="section-tag">HOW IT WORKS</span>
                <h2>Simple Steps to Report a Threat</h2>
                <p>Anyone can report, No technical knowledge needed.</p>
            </div>
            <div class="steps-row">
                <div class="step-card">
                    <div class="step-num">01</div>
                    <div class="step-icon"><i class="fas fa-user-plus"></i></div>
                    <h3>Create an Account</h3>
                    <p>Register for free using your name and email.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">02</div>
                    <div class="step-icon red"><i class="fas fa-flag"></i></div>
                    <h3>Report the Threat</h3>
                    <p>Describe what happened, pick a category and let us know about the incident.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">03</div>
                    <div class="step-icon gold"><i class="fas fa-magnifying-glass"></i></div>
                    <h3>We Verify It</h3>
                    <p>Administrators checks every report to make sure it is real.</p>
                </div>
                <div class="step-card">
                    <div class="step-num">04</div>
                    <div class="step-icon green"><i class="fas fa-bell"></i></div>
                    <h3>Stay Informed</h3>
                    <p>Verified threats will also appear on the public dashboard.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <span class="footer-brand notranslate">Safe<span>Lanka</span></span>
                <p class="footer-desc">Sri Lanka’s trusted platform for reporting and tracking cyber threats.</p>
            </div>
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="report.php">Report a Threat</a></li>
                    <li><a href="dashboard.php">Live Dashboard</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contact Support</h3>
                <ul>
                    <li><i class="fa-solid fa-envelope"></i> help@safelanka.lk</li>
                    <li><i class="fa-solid fa-phone"></i> +94 11 234 5678</li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Staff Access</h3><br>
                <a href="admin_login.php" class="admin-pill">
                    <i class="fa-solid fa-shield-halved"></i> Admin Portal
                </a>
            </div>
        </div>
        <div class="footer-bottom notranslate">
            <p>&copy; <?php echo date("Y"); ?> SafeLanka. All rights reserved.</p>
        </div>
    </footer>

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
        function toggleNav() {
            document.getElementById('navMenu').classList.toggle('open');
        }

        window.onscroll = function () {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        };

        function toggleLanguageMenu(event) {
            event.stopPropagation();
            document.getElementById('languageMenu').classList.toggle('show');
        }

        function toggleUserMenu(event) {
            event.stopPropagation();
            document.getElementById('userDropdown')?.classList.toggle('show');
        }

        window.addEventListener('click', function () {
            document.getElementById('languageMenu')?.classList.remove('show');
            document.getElementById('userDropdown')?.classList.remove('show');
        });

        function setLanguage(langCode) {
        document.cookie = "googtrans=/en/" + langCode + "; path=/";
    
          location.reload();
        }  

        window.addEventListener('DOMContentLoaded', () => {
            let currentLang = 'en';
            if (document.cookie.includes('googtrans=/en/si')) currentLang = 'si';
            if (document.cookie.includes('googtrans=/en/ta')) currentLang = 'ta';

            const labels = { en: 'Language', si: 'සිංහල', ta: 'தமிழ்' };
            document.getElementById('lang-label').innerText = labels[currentLang];
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('service-worker.js')
                    .catch(err => console.warn('ServiceWorker registration failed:', err));
            });
        }
    </script>
</body>
</html>