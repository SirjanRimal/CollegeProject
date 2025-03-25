<?php 
session_start();
include('config.php');

// Uncomment this for authentication
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
//     header("Location: login.php");
//     exit;
// }

// Get pending job approvals
$jobs = $conn->query("SELECT * FROM jobs WHERE is_approved = 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <h2>Pending Job Approvals</h2>
        <div class="job-list">
            <?php while ($job = $jobs->fetch_assoc()): ?>
            <div class="job-card">
                <h3><?= htmlspecialchars($job['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                <p><strong>Salary:</strong> $<?= number_format($job['salary']) ?></p>
                <div class="actions">
                    <a href="approve_job.php?id=<?= $job['job_id'] ?>" class="approve">Approve</a>
                    <a href="delete_job.php?id=<?= $job['job_id'] ?>" class="delete">Delete</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
