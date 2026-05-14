<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['user_otp'];
    
    if ($entered_otp == $_SESSION['temp_user']['otp']) {

        $name = $_SESSION['temp_user']['full_name'];
        $email = $_SESSION['temp_user']['email'];
        $pass = $_SESSION['temp_user']['password'];

        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $pass);

        if ($stmt->execute()) {

            unset($_SESSION['temp_user']);
     
            echo "<script>alert('Account created successfully! You can now login.'); window.location.href='../Frontend/login.php';</script>";
        } else {
            echo "<script>alert('Database Error.'); window.history.back();</script>";
        }
        $stmt->close();
        $conn->close();

    } else {
        echo "<script>alert('Incorrect Code. Try again please.'); window.history.back();</script>";
    }
}
?>