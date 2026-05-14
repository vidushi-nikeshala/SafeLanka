<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if email exists in database
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['reset_email'] = $email;
        
        echo "<script>
            alert('For demonstration only!! \\n\\nAn email with a secure reset link would normally be sent to $email.\\n\\nClick OK to to continue.');
            window.location.href = '../Frontend/new_password.php';
        </script>";
    } else {
        // Email not found
        echo "<script>alert('No account found with that email.'); window.history.back();</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>