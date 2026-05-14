<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }

    $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    $otp = rand(1000, 9999);

    $_SESSION['temp_user'] = [
        'full_name' => $full_name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'otp' => $otp
    ];

    // otp for the demo
    echo "<script>
        alert(' OTP as an example for the Demonstration:  \\n\\nA 
        verification email would normally be sent to: $email\\n\\n
        Your Secure OTP Code is: $otp');
        window.location.href = '../Frontend/otp_page.php';
    </script>";
    exit();
}
?>