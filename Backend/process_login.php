<?php

session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please enter your email and password.";
        header("Location: ../Frontend/login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id']    = $user['user_id'];
            $_SESSION['user_name']  = $user['full_name'];
            $_SESSION['user_email'] = $user['email'];

            $_SESSION['success'] = "Login Successful! Welcome, " . $user['full_name'];
            header("Location: ../Frontend/homepage.php");
            exit();

        } else {
            $_SESSION['error'] = "Incorrect password. Please try again.";
            header("Location: ../Frontend/login.php");
            exit();
        }

    } else {
        $_SESSION['error'] = "No account found with this email.";
        header("Location: ../Frontend/login.php");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    header("Location: ../Frontend/login.php");
    exit();
}
?>