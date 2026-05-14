<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // permission
    if(!isset($_SESSION['reset_email'])) {
        header("Location: ../Frontend/login.php");
        exit();
    }

    $email = $_SESSION['reset_email'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Check pw
    if ($new_pass !== $confirm_pass) {
        echo "<script>alert('Passwords do not match! Try again.'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($new_pass, PASSWORD_BCRYPT);

    // Update DB
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        //  Clear the session and send to login
        unset($_SESSION['reset_email']);
        echo "<script>
            alert('Success! Your password has been updated. Please log in with your new password.');
            window.location.href = '../Frontend/login.php';
        </script>";
    } else {
        echo "<script>alert('Database Error. Could not update password.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
