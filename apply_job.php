<?php
session_start();
include('config.php');

// Uncomment this for authentication
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'job_seeker') {
//     header("Location: login.php");
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
    $job_id = $_POST['job_id'];
    $user_id = $_SESSION['user_id'];
    
    $conn->query("INSERT INTO applications (job_id, user_id) VALUES ($job_id, $user_id)");

    header("Location: job_seeker_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Apply for Job</h2>
        <div class="apply-form">
            <form action="apply.php" method="POST">
                <input type="hidden" name="job_id" value="<?= htmlspecialchars($_GET['job_id'] ?? '') ?>">
                
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="resume">Upload Resume</label>
                <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required>

                <button type="submit">Submit Application</button>
            </form>
        </div>
    </div>
</body>
</html>
