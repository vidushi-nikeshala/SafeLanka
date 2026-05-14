<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first to submit a report.'); window.location.href='../Frontend/login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id     = $_SESSION['user_id'];
    $category    = mysqli_real_escape_string($conn, trim($_POST['category']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $screenshot  = null;

    $incident_time = trim($_POST['incident_time']);
    $severity      = trim($_POST['severity']);
    $target        = trim($_POST['target']);
    $ioc_url       = trim($_POST['ioc_url'] ?? '');
    $ioc_ip        = trim($_POST['ioc_ip'] ?? '');
    $ioc_email     = trim($_POST['ioc_email'] ?? '');
    
    $is_anonymous  = isset($_POST['is_anonymous']) ? 1 : 0;

    if (empty($category) || empty($description) || empty($incident_time) || empty($severity) || empty($target)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    if (!empty($_POST['screenshot_base64'])) {

        $base64_string = $_POST['screenshot_base64'];
        $parts = explode(',', $base64_string);

        if (count($parts) == 2) {
            $header    = $parts[0];
            $mime_type = '';

            if (preg_match('/data:([a-zA-Z0-9]+\/[a-zA-Z0-9]+);base64/', $header, $matches)) {
                $mime_type = $matches[1];
            }

            $allowed_types = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp',
            ];

            if (!array_key_exists($mime_type, $allowed_types)) {
                echo "<script>alert('Invalid file type. Please upload a JPG, PNG, GIF, or WEBP image.'); window.history.back();</script>";
                exit();
            }

            $extension = $allowed_types[$mime_type]; 
            $image_bytes = base64_decode($parts[1]);

            $upload_folder = '../uploads/';
            if (!is_dir($upload_folder)) {
                mkdir($upload_folder, 0755, true);
            }
            $filename = 'screenshot_' . time() . '_' . $user_id . '.' . $extension;
            $filepath = $upload_folder . $filename;

            file_put_contents($filepath, $image_bytes);
            $screenshot = $filename;
        }
    }
    $stmt = $conn->prepare("
        INSERT INTO reports (
            user_id, category, description, screenshot, status, 
            incident_time, severity, target, ioc_url, ioc_ip, ioc_email, is_anonyomus
        ) 
        VALUES (?, ?, ?, ?, 'Pending', ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("isssssssssi", 
        $user_id, 
        $category, 
        $description, 
        $screenshot, 
        $incident_time, 
        $severity, 
        $target, 
        $ioc_url, 
        $ioc_ip, 
        $ioc_email, 
        $is_anonymous
    );

    if ($stmt->execute()) {
        echo "<script>alert('Your report has been submitted! Our team will review it shortly.'); window.location.href='../Frontend/report.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../Frontend/report.php");
    exit();
}
?>