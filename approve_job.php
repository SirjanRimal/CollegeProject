<?php
session_start();
include('config.php');

// Uncomment this for authentication
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//     header("Location: login.php");
//     exit;
// }

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $conn->query("UPDATE jobs SET is_approved = 1 WHERE job_id = $job_id");

    // Redirect after a delay
    header("refresh:3;url=admin_dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Approved</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="message-box">
            <h2>✅ Job Approved Successfully!</h2>
            <p>Redirecting to the admin dashboard in 3 seconds...</p>
            <a href="admin_dashboard.php">Go to Dashboard Now</a>
        </div>
    </div>
</body>
</html>
