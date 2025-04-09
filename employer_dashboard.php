<?php 
session_start();
include('config.php');
include('navbaremployer.php');
// Uncomment this for authentication
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
//     header("Location: login.php");
//     exit;
// }

$jobs = $conn->query("SELECT * FROM jobs WHERE user_id = {$_SESSION['user_id']}");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employer Dashboard</title>
    <link rel="stylesheet" type="text/css" href=".css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Employer</h1>
        
        <a href="post_job.php" class="btn">➕ Post New Job</a>

        <h2>Your Posted Jobs</h2>
        <div class="job-list">
            <?php while ($job = $jobs->fetch_assoc()): ?>
            <div class="job-card">
                <h3><?= htmlspecialchars($job['title']) ?></h3>
                <p><strong>Status:</strong> <span class="<?= $job['is_approved'] ? 'approved' : 'pending' ?>">
                    <?= $job['is_approved'] ? '✅ Approved' : '⏳ Pending Approval' ?>
                </span></p>
                <p><strong>Applications:</strong> <?= 
                    $conn->query("SELECT COUNT(*) FROM applications WHERE job_id = {$job['job_id']}")->fetch_row()[0] ?>
                </p>
            </div>
            <?php endwhile; ?>
        </div>

        <a href="logout.php" class="logout-btn">🚪 Logout</a>
    </div>
</body>
</html>
