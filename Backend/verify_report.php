<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['admin_id'])) { exit("Unauthorized"); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_id = (int)$_POST['report_id'];
    $action = $_POST['action'];
    
    $quick_reason = $_POST['quick_reason'] ?? '';
    $custom_thoughts = trim($_POST['admin_notes']);
    $final_feedback = $quick_reason . $custom_thoughts;

    $status = ($action === 'Approve') ? 'Approved' : 'Rejected';

    $stmt = $conn->prepare("UPDATE reports SET status = ?, admin_notes = ? WHERE report_id = ?");
    $stmt->bind_param("ssi", $status, $final_feedback, $report_id);

    if ($stmt->execute()) {
        header("Location: ../Frontend/admin_dashboard.php?msg=success");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
?>